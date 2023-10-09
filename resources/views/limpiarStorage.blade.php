
<script>
    localStorage.removeItem("carrito");
    var carrito = []
    var msg = '?msg=created';
    window.location.assign(`{{ url('${msg}')}}`);
</script>