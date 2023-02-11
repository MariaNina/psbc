$(document).ready(function () {
    mapboxgl.accessToken =
        "pk.eyJ1IjoiZGV2cm9iZXJ0IiwiYSI6ImNrdDJwbXp4azAwMnUycHBjZmZ3emYzaTEifQ.N9fqww_doaBsYBP6jT7bwQ";

    let map = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/streets-v11",
        center: [121.4846, 14.3629], // [Longtitude, Latitude]
        zoom: 17,
    });

    // Add Marker to Map
    const marker = new mapboxgl.Marker()
        .setLngLat([121.4846, 14.3629])
        .addTo(map);

    // Add zoom and rotation controls to the map.
    map.addControl(new mapboxgl.NavigationControl());
});	
