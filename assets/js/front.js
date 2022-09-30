jQuery(function ($) {
    jQuery(document).ready(function ($) {
    })

    $('#derc-check-address').on('click', function () {
        $.ajax({
            type: 'POST',
            url: derc.url,
            data: {
                q: $('#derc-address').val(),
                action: 'derc_check_address',
                derc_check_address_nonce: derc.nonce.check_address
            },
            success: function (response) {
                if (response.success === true) {
                    window.open(response.data.redirect, '_blank');
                } else {
                    console.log(response.message) // failed search
                }
            }
        })
    })
})

function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 11,
        center: {
            lat: 41.876,
            lng: -87.624
        },
    });
    const kmlLayer = new google.maps.KmlLayer({
        url: "https://digitalenvision.com.au/wp-content/uploads/2021/10/Test%20Zone%20Map.kml",
        map: map,
        suppressInfoWindows: true
    });
    const infowindow = new google.maps.InfoWindow();
    kmlLayer.addListener("click", (kmlEvent) => {
        const text = kmlEvent.latLng.toUrlValue(6);
        const description = kmlEvent.featureData.description;
        const name = kmlEvent.featureData.name;
        infowindow.setContent("<b>" + name + "</b><br>" + description + "<br>" + text);
        infowindow.setPosition(kmlEvent.latLng)
        infowindow.open(map);
    });
}