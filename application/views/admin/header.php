<header class="header">
    <div class="container-fluid d-flex justify-content-end">
        <div class="notification">
    <button class="btn position-relative notification-btn">
        <i class="fas fa-bell bell-icon"></i>
        <span class="position-absolute top-0 start-90 translate-middle badge rounded-circle bg-success notification-dot">
           
        </span>
    </button>
</div>

        <div class="salutation">
            <h5 class="mb-0 textsal">Hi Admin</h5>
        </div>
    </div>
</header>


<style type="text/css">
/* Header Styling */

.header
{
    background-color: #ffffff;
    color: #343a40;
    padding: 10px 20px;
    position: fixed;
    top: 0;
    left: 250px;
    width: calc(100% - 250px);
    z-index: 1030;
    margin-bottom: 20px;
}

/* Adjust for smaller screens */
@media (max-width: 768px) {
    .content {
        margin-left: 0;
        padding-top: 70px;
    }
}


/* Notification Bell Styling */
.notification-btn {
    background: transparent;
    border: none;
    padding: 0;
}

.bell-icon {
    font-size: 24px;
    color: #6c757d;
    animation: bell-shake 1s infinite alternate;
    transition: color 0.3s ease;
}

.notification-btn:hover .bell-icon {
    color: #343a40;
}

/* Notification Dot Styling */
.notification-dot {
    width: 12px;
    height: 14px;
    background-color: #ff3d57;
    border: 2px solid #fff;
}

/* Bell Shake Animation */
@keyframes bell-shake {
    0% {
        transform: rotate(0);
    }
    25% {
        transform: rotate(-10deg);
    }
    50% {
        transform: rotate(10deg);
    }
    75% {
        transform: rotate(-5deg);
    }
    100% {
        transform: rotate(0);
    }
}

/* Adjust for better alignment */
.notification {
    margin-right: 15px;
}

.textsal {
    padding-left: 7px;
}

</style>

