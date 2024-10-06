<template>
    <div class="row">
        <div
            v-for="post in posts"
            :key="post.id"
            class="col-lg-4 col-md-12 post border rounded p-4 mb-4 card position-relative"
        >
            <div class="position-absolute top-0 end-0 m-2">
                <a
                    :href="`/posts/${post.id}`"
                    class="btn btn-primary btn-sm me-1"
                >
                    <i class="fa-regular fa-eye"></i>
                </a>
                <a
                    v-if="authUser && post.user_id === authUser.id"
                    :href="`/posts/${post.id}/edit`"
                    class="btn btn-success btn-sm me-1"
                >
                    <i class="fa-regular fa-edit"></i>
                </a>
                <button
                    v-if="authUser && post.user_id === authUser.id"
                    class="btn btn-danger btn-sm"
                    @click="confirmDelete(post.id)"
                    type="submit"
                >
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>

            <div class="post-header d-flex align-items-center mb-2">
                <h2 class="me-auto">
                    <a :href="`/posts/${post.id}`">{{ post.title }}</a>
                </h2>
                <span class="badge bg-secondary">{{ post.user.username }}</span>
            </div>

            <div class="post-content mb-3">
                <p>{{ post.content }}</p>
                <a :href="`/posts/${post.id}`">
                    <img
                        v-if="post.picture"
                        :src="getPictureUrl(post.picture)"
                        alt="Post Image"
                        class="img-fluid rounded"
                    />
                </a>
            </div>

            <div class="post-comments">
                <h4>Comments ({{ post.comments.length }})</h4>
                <div v-if="post.comments.length === 0">
                    No comments yet. Leave a comment:
                </div>

                <ul class="list-group">
                    <li
                        v-for="comment in post.comments"
                        :key="comment.id"
                        class="list-group-item"
                    >
                        <div>
                            <strong
                                >{{
                                    comment.user ? comment.user.name : "Guest"
                                }}:</strong
                            >
                            {{ comment.content }}
                        </div>

                        <button
                            @click="confirmDeleteComment(post.id, comment.id)"
                            class="border-none"
                        >
                            <i
                                class="fas fa-trash-alt text-danger"
                                style="cursor: pointer"
                            ></i>
                        </button>
                    </li>
                </ul>

                <form @submit.prevent="addComment(post.id)" class="mt-2">
                    <div class="input-group mb-3">
                        <input
                            type="text"
                            v-model="newComment[post.id]"
                            placeholder="Add a comment"
                            class="form-control"
                            required
                        />
                        <button class="btn btn-primary" type="submit">
                            Comment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        authUser: {
            type: Object,
            default: null,
        },
        posts: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            newComment: {},
        };
    },
    methods: {
        getPictureUrl(picture) {
            return `http://localhost:8000/storage/${picture}`;
        },
        addComment(postId) {
            const content = this.newComment[postId];

            if (content) {
                fetch(`posts/${postId}/comments`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({ content }),
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error("Failed to add comment");
                        }
                        return response.json();
                    })
                    .then((newComment) => {
                        const post = this.posts.find((p) => p.id === postId);
                        post.comments.push(newComment);

                        this.newComment[postId] = "";
                    })
                    .catch((error) => {
                        console.error("Error adding comment:", error);
                    });
            }
        },
        confirmDelete(postId) {
            if (confirm("Are you sure you want to delete this post?")) {
                this.deletePost(postId);
            }
        },
        deletePost(postId) {
            fetch(`/posts/${postId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    "Content-Type": "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        this.posts = this.posts.filter(
                            (post) => post.id !== postId
                        );
                    } else {
                        console.error("Failed to delete post", data);
                    }
                })
                .catch((error) => {
                    console.error("Error deleting post:", error);
                });
        },
        confirmDeleteComment(postId, commentId) {
            console.log(postId, commentId);
            if (confirm("Are you sure you want to delete this comment?")) {
                this.deleteComment(postId, commentId);
            }
        },
        deleteComment(postId, commentId) {
            fetch(`/posts/${postId}/comments/${commentId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    "Content-Type": "application/json",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Failed to delete comment");
                    }
                    return response.json(); // Optional if you need to process the response
                })
                .then(() => {
                    // Find the post and remove the comment from the local state
                    const post = this.posts.find((p) => p.id === postId);
                    if (post) {
                        post.comments = post.comments.filter(
                            (comment) => comment.id !== commentId
                        );
                    }
                })
                .catch((error) => {
                    console.error("Error deleting comment:", error);
                });
        },

        canDeleteComment(post, comment) {
            const currentUserId = this.currentUser.id;
            return (
                currentUserId === comment.user_id ||
                currentUserId === post.user_id
            );
        },
    },
};
</script>

<style scoped>
.post {
    background-color: #f8f9fa;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}
.post:hover {
    transform: scale(1.02);
}
.post-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.post-content {
    margin-bottom: 1rem;
}
.post-content img {
    max-height: 200px;
}
@media (max-width: 992px) {
    .post-content img {
        max-height: auto;
    }
}
.post-comments {
    margin-top: 1rem;
}
.list-group-item {
    display: flex;
    justify-content: space-between;
}
.list-group-item button {
    border: none;
    background-color: #fff;
}
.post a {
    color: #000;
    text-decoration: none;
}
.post a svg {
    color: #fff;
    font-weight: bold;
}
</style>
