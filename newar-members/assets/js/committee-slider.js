(function () {
    'use strict';

    var sliders = document.querySelectorAll('.newar-committee-slider');
    if (!sliders.length) return;

    var AUTO_SCROLL_INTERVAL = 3500;
    var RESUME_DELAY = 3000;

    function initSlider(container) {
        var track = container.querySelector('.newar-committee-slider__track');
        var prevBtn = container.querySelector('.newar-committee-slider__arrow--prev');
        var nextBtn = container.querySelector('.newar-committee-slider__arrow--next');
        if (!track) return;

        var autoScrollTimer = null;
        var resumeTimer = null;
        var userInteracted = false;
        var currentIndex = 0;
        var slides = track.querySelectorAll('.newar-committee-slider__slide');
        var slideCount = slides.length;

        if (slideCount === 0) return;

        if (slideCount <= 1) {
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
            return;
        }

        var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        function scrollToIndex(index, smooth) {
            if (index < 0) index = slideCount - 1;
            if (index >= slideCount) index = 0;
            currentIndex = index;
            var targetSlide = slides[index];
            if (!targetSlide) return;
            var targetLeft = targetSlide.offsetLeft - track.offsetLeft;
            track.scrollTo({
                left: targetLeft,
                behavior: smooth !== false && !prefersReducedMotion ? 'smooth' : 'auto'
            });
        }

        function stopAutoScroll() {
            clearInterval(autoScrollTimer);
            clearTimeout(resumeTimer);
            autoScrollTimer = null;
            resumeTimer = null;
        }

        function startAutoScroll() {
            if (userInteracted || prefersReducedMotion) return;
            stopAutoScroll();
            autoScrollTimer = setInterval(function () {
                scrollToIndex(currentIndex + 1);
            }, AUTO_SCROLL_INTERVAL);
        }

        function scheduleResume() {
            if (userInteracted || prefersReducedMotion) return;
            clearTimeout(resumeTimer);
            resumeTimer = setTimeout(function () {
                startAutoScroll();
            }, RESUME_DELAY);
        }

        function onUserInteract() {
            userInteracted = true;
            stopAutoScroll();
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                onUserInteract();
                scrollToIndex(currentIndex - 1);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                onUserInteract();
                scrollToIndex(currentIndex + 1);
            });
        }

        track.addEventListener('mouseenter', function () {
            stopAutoScroll();
        });

        track.addEventListener('mouseleave', function () {
            if (!userInteracted) {
                scheduleResume();
            }
        });

        track.addEventListener('touchstart', function () {
            stopAutoScroll();
            onUserInteract();
        }, { passive: true });

        track.addEventListener('focusin', function () {
            stopAutoScroll();
        });

        track.addEventListener('focusout', function () {
            if (!userInteracted) {
                scheduleResume();
            }
        });

        track.addEventListener('scroll', function () {
            var scrollLeft = track.scrollLeft;
            var closestIndex = 0;
            var closestDist = Infinity;
            slides.forEach(function (slide, index) {
                var dist = Math.abs(slide.offsetLeft - track.offsetLeft - scrollLeft);
                if (dist < closestDist) {
                    closestDist = dist;
                    closestIndex = index;
                }
            });
            currentIndex = closestIndex;
        });

        scrollToIndex(0, false);

        if (!prefersReducedMotion) {
            startAutoScroll();
        }
    }

    sliders.forEach(initSlider);
})();
