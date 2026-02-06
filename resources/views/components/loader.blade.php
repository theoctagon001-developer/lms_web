<div id="loader" class="hidden fixed top-0 left-0 w-full h-full flex justify-center items-center bg-white bg-opacity-50">
    <div class="w-20 h-20 border-4 border-transparent text-blue-400 text-4xl animate-spin flex items-center justify-center border-t-blue-400 rounded-full">
        <div class="w-16 h-16 border-4 border-transparent text-red-400 text-2xl animate-spin flex items-center justify-center border-t-red-400 rounded-full"></div>
    </div>
</div>
<script>
    window.addEventListener("load", function() {
        document.getElementById("loader").classList.add("hidden");
    });

    function showLoader() {
        document.getElementById("loader").classList.remove("hidden");
    }

    function hideLoader() {
        document.getElementById("loader").classList.add("hidden");
    }

</script>