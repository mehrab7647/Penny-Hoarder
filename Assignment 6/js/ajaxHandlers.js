document.addEventListener('DOMContentLoaded', () => {
    // Check if we're on the login or home page for periodic blog updates
    if (document.getElementById('recent')) {
        setupPeriodicBlogUpdates();
    }

    // Check if we're on the blog details page
    if (document.querySelector('.content-box')) {
        setupPeriodicCommentUpdates();
        setupVoteHandlers();
    }
});

function setupPeriodicBlogUpdates() {
    // Function to fetch new blogs
    function fetchNewBlogs() {
        // Get the ID of the most recent blog currently on the page
        const posts = document.querySelectorAll('#posts');
        const lastPostId = posts.length > 0 ? posts[0].dataset.postId || 0 : 0;

        const xhr = new XMLHttpRequest();
        xhr.open('GET', `get_recent_blogs.php?last_id=${lastPostId}`, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.responseType = 'json';

        xhr.onload = function() {
            if (xhr.status === 200) {
                const newBlogs = xhr.response;
                if (newBlogs.length > 0) {
                    const postsContainer = document.getElementById('recent');
                    
                    // Remove oldest blogs if needed
                    while (postsContainer.querySelectorAll('#posts').length >= 5) {
                        postsContainer.removeChild(postsContainer.lastElementChild);
                    }

                    // Add new blogs to the top
                    newBlogs.forEach(blog => {
                        const newPostDiv = document.createElement('div');
                        newPostDiv.id = 'posts';
                        newPostDiv.dataset.postId = blog.id;
                        newPostDiv.innerHTML = `
                            <div id="post-info">
                                <p>${blog.screenname}</p>
                                <p>${blog.title}</p>
                                <p>${blog.comment_count} Comments</p>
                                <p>${blog.created_at}</p>
                            </div>
                            <div id="post-img">
                                <img src="${blog.avatar}" alt="User Avatar" height="150" width="150"/>
                                <form action="blogdetails.php?id=${blog.id}">
                                    <input type="submit" value="See More..." />
                                </form>
                            </div>
                        `;
                        postsContainer.insertBefore(newPostDiv, postsContainer.firstChild);
                    });
                }
            }
        };

        xhr.send();
    }

    // Check for new blogs every 2 minutes
    setInterval(fetchNewBlogs, 2 * 60 * 1000);
}

function setupPeriodicCommentUpdates() {
    function fetchCommentUpdates() {
        const postId = window.location.search.split('id=')[1];
        
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `get_comment_updates.php?post_id=${postId}`, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.responseType = 'json';

        xhr.onload = function() {
            if (xhr.status === 200) {
                const updates = xhr.response;

                // Update comment votes
                const commentItems = document.querySelectorAll('.comment-item');
                commentItems.forEach((commentItem, index) => {
                    if (updates.comments[index]) {
                        const voteCount = commentItem.querySelector('.vote-count-new');
                        const currentVotes = parseInt(voteCount.textContent);
                        const newVotes = updates.comments[index].upvotes;

                        if (currentVotes !== newVotes) {
                            voteCount.textContent = newVotes;
                            voteCount.classList.add('highlight');
                            
                            // Remove highlight after 5 seconds
                            setTimeout(() => {
                                voteCount.classList.remove('highlight');
                            }, 5000);
                        }
                    }
                });

                // Update post votes
                const postVoteCount = document.querySelector('.vote-count-new');
                if (postVoteCount && updates.post) {
                    const currentPostVotes = parseInt(postVoteCount.textContent);
                    const newPostVotes = updates.post.upvotes;

                    if (currentPostVotes !== newPostVotes) {
                        postVoteCount.textContent = newPostVotes;
                        postVoteCount.classList.add('highlight');
                        
                        // Remove highlight after 5 seconds
                        setTimeout(() => {
                            postVoteCount.classList.remove('highlight');
                        }, 5000);
                    }
                }
            }
        };

        xhr.send();
    }

    // Check for comment updates every 2 minutes
    setInterval(fetchCommentUpdates, 2 * 60 * 1000);
}

function setupVoteHandlers() {
    // Voting for post
    const postUpvoteIcon = document.querySelector('.vote-icon');
    const postDownvoteIcon = document.querySelector('.downvote-icon');
    const postVoteCount = document.querySelector('.vote-count-new');

    // Add null checks
    if (postUpvoteIcon && postDownvoteIcon && postVoteCount) {
        postUpvoteIcon.addEventListener('click', () => handleVote('post', 'upvote'));
        postDownvoteIcon.addEventListener('click', () => handleVote('post', 'downvote'));
    }

    // Voting for comments
    const commentVoteIcons = document.querySelectorAll('.comment-actions .vote-icon, .comment-actions .downvote-icon');
    commentVoteIcons.forEach(icon => {
        // Ensure each icon is valid before adding listener
        if (icon) {
            icon.addEventListener('click', (event) => {
                const isUpvote = event.target.classList.contains('vote-icon');
                const commentItem = event.target.closest('.comment-item');
                
                // Additional null check for commentItem
                if (commentItem) {
                    const commentId = commentItem.dataset.commentId;
                    handleVote('comment', isUpvote ? 'upvote' : 'downvote', commentId);
                }
            });
        }
    });
}

    function handleVote(type, voteType, itemId = null) {
        // Check for valid post ID
        const postId = window.location.search.split('id=')[1];
        if (!postId) {
            console.error('No post ID found');
            return;
        }
        
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'process_vote.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.responseType = 'json';
    
        xhr.onerror = function() {
            console.error('Network error occurred');
        };
    
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = xhr.response;
                
                try {
                    if (type === 'post') {
                        // Ensure postVoteCount exists before modifying
                        const postVoteCount = document.querySelector('.vote-count-new');
                        if (postVoteCount) {
                            postVoteCount.textContent = response.upvotes;
                        } else {
                            console.error('Post vote count element not found');
                        }
                    } else if (type === 'comment') {
                        const commentItem = document.querySelector(`.comment-item[data-comment-id="${itemId}"]`);
                        if (commentItem) {
                            const voteCount = commentItem.querySelector('.vote-count-new');
                            if (voteCount) {
                                voteCount.textContent = response.upvotes;
                            } else {
                                console.error('Comment vote count element not found');
                            }
                        } else {
                            console.error(`Comment item with ID ${itemId} not found`);
                        }
                    }
                } catch (error) {
                    console.error('Error processing vote response:', error);
                }
            } else {
                console.error(`Server responded with status ${xhr.status}`);
            }
        };
    
        const data = itemId 
            ? `type=${type}&vote_type=${voteType}&post_id=${postId}&comment_id=${itemId}`
            : `type=${type}&vote_type=${voteType}&post_id=${postId}`;
        
        xhr.send(data);
    }