function redirectToRoute(destination) {
    // Redirect user to route.html with the selected destination as a query parameter
    window.location.href = `route.php?destination=${encodeURIComponent(destination)}`;
}
