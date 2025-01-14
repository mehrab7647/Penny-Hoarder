document.addEventListener('DOMContentLoaded', () => {
    const blogContent = document.getElementById("content");
    const commentField = document.getElementById("comment");

    // Dynamic character counter for blog content
    if (blogContent) {
        const charCountContent = document.getElementById("character-count-content");
        blogContent.addEventListener("input", () => {
            const remaining = 2000 - blogContent.value.length;
            charCountContent.textContent = `${remaining} characters left`;
            if (remaining < 0) {
                charCountContent.classList.add("error");
            } else {
                charCountContent.classList.remove("error");
            }
        });
    }

    // Dynamic character counter for comments
    if (commentField) {
        const charCountComment = document.getElementById("character-count-comment");
        commentField.addEventListener("input", () => {
            const remaining = 1000 - commentField.value.length;
            charCountComment.textContent = `${remaining} characters left`;
            if (remaining < 0) {
                charCountComment.classList.add("error");
            } else {
                charCountComment.classList.remove("error");
            }
        });
    }
});
