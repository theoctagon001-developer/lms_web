<meta name="csrf-token" content="{{ csrf_token() }}">
<script type="module">
    import { requestNotificationPermission } from "/js/firebase.js";

    document.addEventListener("DOMContentLoaded", () => {
        requestNotificationPermission();
    });
</script>
