function openBookingDay(evt, bookingDay) {
    // Declare all variables
    var i, verticaltab, verticaltablinks;

    // Get all elements with class="tabcontent" and hide them
    verticaltab = document.getElementsByClassName("verticaltab");
    for (i = 0; i < verticaltab.length; i++) {
        verticaltab[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    verticaltablinks = document.getElementsByClassName("verticaltablinks");
    for (i = 0; i < verticaltablinks.length; i++) {
        verticaltablinks[i].className = verticaltablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the link that opened the tab
    document.getElementById(bookingDay).style.display = "block";
    evt.currentTarget.className += " active";
}
// JavaScript File
