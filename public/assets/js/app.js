const app = {

    init: function () {
        const eyeIcons = document.querySelectorAll('.eyeIcon');
        app.addEyeIconMouseOverEventsOn(eyeIcons);
        app.addEyeIconMouseLeaveEventsOn(eyeIcons);

        const squareIcons = document.querySelectorAll('.squareIcon');
        app.addSquareIconsMouseOverOn(squareIcons);
        app.addSquareIconsMouseLeaveOn(squareIcons);
    },

    // #region eyeIcons events
    addEyeIconMouseOverEventsOn: function (eyeIcons) {
        for (const el of eyeIcons) {
            el.addEventListener('mouseover', app.onEyeIconMouseOver);
        }
    },

    addEyeIconMouseLeaveEventsOn: function (eyeIcons) {
        for (const el of eyeIcons) {
            el.addEventListener('mouseleave', app.onEyeIconMouseLeave);
        }
    },

    onEyeIconMouseOver: function (evt) {
        const eyeIconSpan = evt.target;
        eyeIconSpan.classList.remove('bi-eye');
        eyeIconSpan.classList.add('bi-eye-fill');
    },

    onEyeIconMouseLeave: function (evt) {
        const eyeIconSpan = evt.target.querySelector('.bi');
        eyeIconSpan.classList.remove('bi-eye-fill');
        eyeIconSpan.classList.add('bi-eye');
    },
    //#endregion

    //#region squareIcons events
    addSquareIconsMouseOverOn: function (squareIcons) {
        for (const el of squareIcons) {
            el.addEventListener('mouseover', app.onSquareIconMouseOver);
        }
    },

    addSquareIconsMouseLeaveOn: function (squareIcons) {
        for (const el of squareIcons) {
            el.addEventListener('mouseleave', app.onSquareIconMouseLeave);
        }
    },

    onSquareIconMouseOver: function (evt) {
        const squareIcon = evt.target;
        squareIcon.classList.remove('bi-arrow-right-square');
        squareIcon.classList.add('bi-arrow-right-square-fill');
    },

    onSquareIconMouseLeave: function (evt) {
        const squareIcon = evt.target.querySelector('.bi');
        squareIcon.classList.remove('bi-arrow-right-square-fill');
        squareIcon.classList.add('bi-arrow-right-square');
    },
    //#endregion

}

document.addEventListener('DOMContentLoaded', app.init);