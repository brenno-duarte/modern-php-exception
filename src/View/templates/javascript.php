<script>
    window.onload = function() {
        for (var i = 0; i < 10; i++) {
            show('<?= $main_error ?>')
        }
    };

    function show(id) {
        if (document.getElementById(id).style.display !== "none") {
            document.getElementById(id).style.display = "none";
            return;
        }

        Array.from(document.getElementsByClassName("hidden")).forEach(
            section => (section.style.display = "none")
        );

        document.getElementById(id).style.display = "block";
    }
</script>