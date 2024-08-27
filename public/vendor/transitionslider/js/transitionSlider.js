/*
Transition Slider jQuery plugin
version 2.15.0
author http://codecanyon.net/user/creativeinteractivemedia/portfolio?ref=creativeinteractivemedia
*/
var STX = STX || {};
(function($) {
    "use strict";

    function TransitionSlider(elem, options, callback) {
        var self = this;

        self.mainContainer = $("<div />").addClass("stx-main-container");
        $(elem).append(self.mainContainer);

        self.$sliderWrapper = self.mainContainer;

        self.$window = $(window);
        self.ev = $(self);
        extendOptions(options);
        if (callback) self.callback = callback;

        function init() {
            setupEventListeners();
            generateHTMLElementsForSwiper();
            addStyleToSlider();
            calculateSlidesValuesFromOptions();
            initLoading();
            initLayers();
            initTransition();
            self.initialized = true;
        }

        function isVisible() {
            var sliderHeight = self.$sliderWrapper.height();
            var sliderTop = self.$sliderWrapper.offset().top;
            var sliderBottom = sliderTop + sliderHeight;
            var viewportTop = self.$window.scrollTop();
            var viewportBottom = viewportTop + self.$window.height();
            var inside = sliderBottom > viewportTop && sliderTop < viewportBottom;
            var sliderTopCut = Math.max(0, viewportTop - sliderTop);
            var sliderBottomCut = Math.max(0, sliderBottom - viewportBottom);
            var sliderCut = sliderTopCut - sliderBottomCut;

            self.$sliderWrapper.find(".stx-parallax").each(function() {
                if (!this.dataset.scale) this.style.transform = "translateY(" + sliderCut * this.dataset.stxParallax + "px)";
                else this.style.transform = "scale(" + this.dataset.scale + ") translateY(" + (sliderCut * this.dataset.stxParallax) / this.dataset.scale + "px)";

                this.dataset.translateY = sliderCut * this.dataset.stxParallax;
            });

            return inside;
        }

        function updateRendering() {
            if (isVisible()) {
                if (!self.initialized) init();
                self.transition.enableRendering();
            } else {
                if (self.initialized) self.transition.disableRendering();
            }
        }

        self.updateSizeValuesOnResize();
        self.checkForLightboxMode(elem);

        if (isVisible()) init();

        self.ev.on("animationComplete", updateRendering);
        self.$window.on("resize scroll", updateRendering);

        if (self.options.wheelNavigation.enable) {
            self.$sliderWrapper[0].addEventListener(
                "wheel",
                function(e) {
                    e.preventDefault();
                    if (self.wheelDisabled) return;
                    self.wheelDisabled = true;
                    setTimeout(function() {
                        self.wheelDisabled = false;
                    }, self.options.wheelNavigation.interval);
                    if (e.deltaY > 0 && (self.swiper.activeIndex !== self.swiper.slides.length - 1 || !self.options.wheelNavigation.stopOnLast)) {
                        self.swiper.slideNext();
                    } else if (e.deltaY < 0 && (self.swiper.activeIndex || !self.options.wheelNavigation.stopOnLast)) {
                        self.swiper.slidePrev();
                    }
                },
                { passive: false }
            );
        }

        function extendOptions(options) {
            self.options = $.extend(true, {}, $.fn.transitionSlider.defaults, options);

            if (self.options.pagination.enable) {
                self.options.pagination.el = ".swiper-pagination";
                self.options.pagination.type = "bullets";
                if (self.options.pagination.style == "effect3" || self.options.pagination.style == "effect4") self.options.pagination.type = "fraction";
            }

            self.options.slides.forEach(function(slide) {
                slide.mediaType = STX.Utils.checkForSupportedMediaType(slide.src).mediaType;
                slide.mediaExtension = STX.Utils.checkForSupportedMediaType(slide.src).mediaExtension;
                if (slide.thumbSrc) {
                    slide.thumbMediaType = STX.Utils.checkForSupportedMediaType(slide.thumbSrc).mediaType;
                    slide.thumbMediaExtension = STX.Utils.checkForSupportedMediaType(slide.thumbSrc).mediaExtension;
                }
                slide.src = STX.Utils.checkForURLProtocol(slide.src);
            });
        }

        function setupEventListeners() {
            self.ev.on("hideLoadingAfterInitAssets", function() {
                self.hideLoadingAfterInitAssetsLoad();
            });
            self.ev.on("initSwiper", function() {
                if (self.options.thumbs && self.options.thumbs.enable !== false) initThumbs();
                initSwiper();
            });
            self.ev.on("enableSwiperInteraction", function() {
                self.enableSwiper();
                self.updateLayerSizeForSlide();
            });
            self.ev.on("disableSwiperInteraction", function() {
                self.disableSwiper();
            });
            self.ev.on("onPauseButtonUpdate", function(event, paused) {
                paused ? self.pauseAutoplay() : self.startAutoplay();
            });
            self.ev.on("updateAspectRatio", function() {
                self.onUpdateAspectRatio();
            });
            self.ev.on("animateLayer", function() {
                isVisible();
            });
            self.ev.on("showLoading", function() {
                if (self.callback) {
                    self.callback();
                    self.callback = null;
                }
            });
        }

        function generateHTMLElementsForSwiper() {
            self.$sliderWrapper.css({ position: "relative", margin: "auto" });

            if (self.options.fullscreen) {
                self.options.forceResponsive = false;

                if (self.options.forceFullscreen) self.updateForceWidth();
            }

            if (self.options.responsive) {
                self.options.forceFullscreen = false;

                if (self.options.forceResponsive) self.updateForceWidth();
            }

            if (!self.container) {
                self.container = document.createElement("div");
                self.container.setAttribute("class", "stx-container");
            }

            if (!self.swiperWrapperDiv) {
                self.swiperContainerDiv = document.createElement("div");
                self.swiperContainerDiv.className = "swiper-container";
                self.swiperWrapperDiv = document.createElement("div");
                self.swiperWrapperDiv.className = "swiper-wrapper";
                self.swiperContainerDiv.appendChild(self.swiperWrapperDiv);
                $(self.swiperContainerDiv).css({ overflow: "hidden" });

                self.$sliderWrapper.append($(self.swiperContainerDiv));
                self.$sliderWrapper.prepend($(self.container));
            }

            if (self.options.slides) {
                var generateUnmuteButton = false;

                for (var i = 0; i < self.options.slides.length; i++) {
                    var slideDiv;

                    if (self.options.slides[i].url) {
                        slideDiv = document.createElement("a");

                        slideDiv.href = self.options.slides[i].url;
                        slideDiv.target = self.options.slides[i].urlTarget || "_blank";
                    } else {
                        slideDiv = document.createElement("div");
                    }
                    slideDiv.className = "swiper-slide";

                    if ((typeof self.options.hashNavigation === "object" && self.options.hashNavigation.enable) || (typeof self.options.hashNavigation === "boolean" && self.options.hashNavigation)) {
                        slideDiv.setAttribute("data-hash", "slide" + i);
                    }

                    self.swiperWrapperDiv.appendChild(slideDiv);
                    if (!generateUnmuteButton && self.options.slides[i].mediaType === "VIDEO") {
                        generateUnmuteButton = true;
                        self.unmute = new STX.Buttons({
                            ev: self.ev,
                            buttons: self.options.buttons,
                            videoAutoplay: self.options.videoAutoplay
                        });
                        self.$unmute = self.unmute.getUnmuteDivElement();
                        self.$sliderWrapper.append(self.$unmute);
                    }
                }
            }

            if (self.options.navigation) {
                self.navigationNextDiv = document.createElement("div");
                self.navigationPrevDiv = document.createElement("div");

                self.navigationNextDiv.className += "slider-arrow slider-arrow-next " + self.options.navigation.style.replace("effect", "arrow");
                self.navigationPrevDiv.className += "slider-arrow slider-arrow-prev " + self.options.navigation.style.replace("effect", "arrow");

                self.navigationNextTouchAreaDiv = document.createElement("div");
                self.navigationPrevTouchAreaDiv = document.createElement("div");
                self.navigationNextTouchAreaDiv.className = "slider-touch-area-next";
                self.navigationPrevTouchAreaDiv.className = "slider-touch-area-prev";
                self.options.navigation.nextEl = ".slider-touch-area-next";
                self.options.navigation.prevEl = ".slider-touch-area-prev";
                self.navigationNextTouchAreaDiv.appendChild(self.navigationNextDiv);
                self.navigationPrevTouchAreaDiv.appendChild(self.navigationPrevDiv);

                self.swiperContainerDiv.appendChild(self.navigationNextTouchAreaDiv);
                self.swiperContainerDiv.appendChild(self.navigationPrevTouchAreaDiv);
            }

            if (self.options.pagination.enable) {
                self.paginationDiv = document.createElement("div");
                self.paginationDiv.className = "swiper-pagination " + self.options.pagination.style.replace("effect", "pagination");
                self.swiperContainerDiv.appendChild(self.paginationDiv);
            }

            if (self.options.scrollbar) {
                self.scrollbarDiv = document.createElement("div");
                self.scrollbarDiv.className = self.options.scrollbar.el.replace(/^\./, "");
                self.swiperContainerDiv.appendChild(self.scrollbarDiv);
            }
        }

        function addStyleToSlider() {
            if (self.options.shadow) self.$sliderWrapper.addClass("sliderTX_" + self.options.shadow);
        }

        function handleTransition(slide) {
            if (typeof slide.transition != "string" || options.mode == "css") return slide;

            var effectOptions = STX.Effects[slide.transition];
            if (effectOptions) {
                slide.transitionEffect = effectOptions.effect;
                slide.transitionDuration = effectOptions.duration;
                slide.distance = effectOptions.distance;
                slide.easing = effectOptions.easing;
                slide.blur = effectOptions.blur;
                slide.brightness = effectOptions.brightness;
                slide.direction = effectOptions.direction;
            }
            return slide;
        }

        function calculateSlidesValuesFromOptions() {
            if (self.options.slides) {
                self.options.transitionDurations = [];
                self.options.slides.forEach(function(slide) {
                    handleTransition(slide);
                    if (slide.transitionDuration === 0 || slide.transitionDuration === null || slide.transitionDuration === undefined) slide.transitionDuration = self.options.transitionDuration;
                    if (slide.transitionEffect === "" || slide.transitionEffect === null || slide.transitionEffect === undefined) slide.transitionEffect = self.options.transitionEffect;
                    if (slide.direction === "" || slide.direction === null || slide.direction === undefined) slide.direction = self.options.direction;
                    if (slide.brightness === "" || slide.brightness === null || slide.brightness === undefined) slide.brightness = self.options.brightness;
                    if (slide.distance === "" || slide.distance === null || slide.distance === undefined) slide.distance = self.options.distance;
                    if (slide.easing === "" || slide.easing === null || slide.easing === undefined) slide.easing = self.options.easing;
                    self.options.transitionDurations.push(slide.transitionDuration);
                });
            }
        }

        function checkForDeepLinking(options) {
            var slideIndex;

            if ((typeof self.options.hashNavigation === "object" && self.options.hashNavigation.enable) || (typeof self.options.hashNavigation === "boolean" && self.options.hashNavigation)) {
                var hash = document.location.hash.replace("#", "");
                if (hash.includes("slide")) {
                    slideIndex = parseInt(hash.replace("slide", ""));
                } else {
                    slideIndex = options.initialSlide;
                }
            } else {
                slideIndex = options.initialSlide;
            }

            return slideIndex;
        }

        function initTransition() {
            var initialSlideIndex = checkForDeepLinking(self.options);

            var o = {
                container: self.container,
                ev: self.ev,
                layers: self.layers,
                initialSlide: initialSlideIndex,
                initialEffect: self.options.slides[initialSlideIndex].transitionEffect,
                slidesToLoad: self.options.slides,
                camera: {
                    width: self.$sliderWrapper.width(),
                    height: self.$sliderWrapper.height(),
                    fov: 75
                },
                parallax: self.options.parallax,
                resetVideos: self.options.resetVideos,
                videoAutoplay: self.options.videoAutoplay,
                swiperContainer: self.swiperContainerDiv,
                layerStarOnTransitionStart: self.options.layerStarOnTransitionStart
            };

            var transitionClassName = self.options.mode == "css" ? "TransitionSwipe" : "Transition";

            self.transition = new STX[transitionClassName](o);
        }

        function initLayers() {
            self.layers = new STX.Layers(self.options, self.ev, self.$sliderWrapper);
            self.$layers = $(self.layers.getLayerDivElement());
            self.$layers.insertAfter($(self.swiperWrapperDiv));

            if (self.options.overlay) {
                self.overlay = document.createElement("div");
                $(self.overlay)
                    .insertBefore(self.$layers)
                    .addClass("stx-overlay");
                self.overlay.style.background = self.options.overlay;
            }
        }

        function initLoading() {
            self.loading = new STX.Loading(self.options.loading, self.ev);
            self.$sliderWrapper.append($(self.loading.getLoadingDivElement()));
        }

        function initThumbs() {
            self.swiperContainerDiv.classList.add("gallery-top");
            self.thumbnails = new STX.Thumbnails(self.options, self.ev);
            self.$sliderWrapper.append($(self.thumbnails.getLoadingDivElement()));
            self.options.thumbs.swiper = self.thumbnails.thumbOptions;
        }

        function initSwiper() {
            self.options.speed = self.options.slides[self.options.initialSlide].transitionDuration;

            self.options.roundLengths = true;
            self.options.watchOverflow = true;
            self.options.preventInteractionOnTransition = true;
            self.options.slidesPerView = "auto";
            self.options.longSwipesRatio = 0.5;

            self.swiper = new STXSwiper(self.swiperContainerDiv, self.options);

            self.swiper.on("resize", function() {
                self.onResize();
            });

            self.swiper.on(
                "resize",
                debounce(function() {
                    if (!self.swiper.animating) self.ev.trigger("updateRendererStatus", [false]);
                })
            );

            self.swiper.on("slideNextTransitionStart", function() {
                self.nextSlide(self.swiper.previousIndex, self.swiper.realIndex);
                self.stopAutoplay();
            });

            self.swiper.on("slidePrevTransitionStart", function() {
                self.prevSlide(self.swiper.previousIndex, self.swiper.realIndex);
                self.stopAutoplay();
            });

            self.swiper.on("slideChange", function(e) {
                self.ev.trigger("slideChange");
            });

            self.swiper.on("slideChangeTransitionEnd", function(e) {
                self.ev.trigger("slideChangeTransitionEnd");
            });

            function debounce(func) {
                var timer;
                return function(event) {
                    if (timer) clearTimeout(timer);
                    timer = setTimeout(func, 150, event);
                };
            }

            self.stopAutoplay();
            self.updateSwiperStyle();
            self.updateLayerSizeForSlide();
            self.slideChanged(self.swiper.activeIndex);

            if (self.options.slides.length === 1) return;

            self.swiper.on("slideResetTransitionStart", function() {
                var progress = this.touches.diff / this.width;
                var a = { val: this.touches.diff / this.width };
                anime({
                    targets: a,
                    val: 0,
                    duration: 300,
                    easing: "easeOutQuad",
                    update: function() {
                        self.slideMove(a.val);
                    },
                    complete: function() {
                        self.swiper.animating = false;
                    }
                });
            });

            self.swiper.on("slideResetTransitionEnd", function() {
                var progress = this.touches.diff / this.width;
                if (progress > 0.25) self.swiper.slidePrev();
                else if (progress < -0.25) self.swiper.slideNext();
                self.resetAutoplay();
            });

            self.swiper.on("touchStart", function(e) {
                this.touches.diff = 0;
                self.slideMove(0);
                self.stopAutoplay();
            });

            self.swiper.on("touchMove", function(e) {
                var progress = this.touches.diff / this.width;
                self.slideMove(progress);
                self.stopAutoplay();
            });
        }

        function removeHTMLElementsAndStyles() {
            self.swiper.removeAllSlides();

            if (self.options.navigation) {
                $(self.navigationNextDiv).remove();
                $(self.navigationPrevDiv).remove();
                $(self.navigationNextTouchAreaDiv).remove();
                $(self.navigationPrevTouchAreaDiv).remove();
            }

            if (self.options.pagination.enable) {
                $(self.paginationDiv).remove();
            }

            if (self.options.scrollbar) {
                $(self.scrollbarDiv).remove();
            }

            if (self.options.shadow) {
                self.container.classList.remove("sliderTX_" + self.options.shadow);
            }

            if (self.$unmute) {
                self.$unmute.remove();
            }
            if (self.thumbnails) {
                self.thumbnails.removeStyle();
            }
            if (self.options.lightboxMode.enable) {
                self.mainContainer
                    .detach()
                    .appendTo("#slider-preview")
                    .css({ top: 0, left: 0 });
                self.lightboxOverlay.remove();
                self.lightboxText.remove();
            }
            self.loading.removeStyle();

            jQuery("#" + self.paginationNavigationStyleID).remove();
        }

        self.reloadSlider = function(newSliderOptions, callback) {
            if (callback) self.callback = callback;
            self.stopSlider();
            removeHTMLElementsAndStyles();
            extendOptions(newSliderOptions);

            var initialSlideIndex = checkForDeepLinking(self.options);

            self.swiper.destroy(false, true);

            calculateSlidesValuesFromOptions();
            generateHTMLElementsForSwiper();
            self.loading.createStyle(self.options.loading);
            self.slideMove(0);
            self.updateSizeValuesOnResize();
            self.checkForLightboxMode(elem);
            self.layers.reloadLayer(self.options);
            self.updateLayerSizeForSlide();
            addStyleToSlider();
            self.transition.reloadTransition({
                initialSlide: initialSlideIndex,
                initialEffect: self.options.slides[initialSlideIndex].transitionEffect,
                slidesToLoad: self.options.slides,
                camera: {
                    width: self.options.width,
                    height: self.options.height,
                    fov: 75
                }
            });
        };

        self.stopSlider = function() {
            self.transition.pauseAllVideoSlides();
            self.stopAutoplay();
        };
    }

    TransitionSlider.prototype = {
        constructor: TransitionSlider,

        hideLoadingAfterInitAssetsLoad: function() {
            var self = this;

            self.resetAutoplay();
            self.ev.trigger("hideLoading");
        },

        onResize: function() {
            var self = this;

            self.updateSizeValuesOnResize();
            if (self.swiper) self.swiper.update(); 
            if (self.options.mode == "css") self.swiper.animating = false; 
            if (self.transition) {
                self.transition.updateTransitionOnResize({
                    width: self.$sliderWrapper.width(),
                    height: self.$sliderWrapper.height()
                });
            }
            if (self.options.lightboxMode.enable) {
                $(self.mainContainer).css({
                    position: "absolute",
                    left: window.innerWidth / 2 - $(self.mainContainer).width() / 2,
                    top: window.innerHeight / 2 - $(self.mainContainer).height() / 2
                });
            }
        },

        onUpdateAspectRatio: function() {
            if (this.transition) {
                this.transition.updateTransitionOnResize({
                    width: this.$sliderWrapper.width(),
                    height: this.$sliderWrapper.height()
                });
            }
        },

        updateSizeValuesOnResize: function() {
            var self = this;
            var o = self.options;
            var marginLeft = 0;
            var marginRight = 0;
            var marginTop = 0;
            var marginBottom = 0;
            var parentWidth = self.$sliderWrapper.parent().width();

            if (self.options.thumbs.enable && self.options.thumbs.outsideSlider) {
                var position = self.options.thumbs.position;
                switch (position) {
                    case "top":
                        marginTop = Number(self.options.thumbs.thumbHeight) + 2 * Number(self.options.thumbs.spaceAround);
                        break;
                    case "left":
                        marginLeft = Number(self.options.thumbs.thumbWidth) + 2 * Number(self.options.thumbs.spaceAround);
                        break;
                    case "right":
                        marginRight = Number(self.options.thumbs.thumbWidth) + 2 * Number(self.options.thumbs.spaceAround);
                        break;
                    case "bottom":
                        marginBottom = Number(self.options.thumbs.thumbHeight) + 2 * Number(self.options.thumbs.spaceAround);
                        break;
                }
                self.$sliderWrapper.css("margin", marginTop + "px " + marginRight + "px " + marginBottom + "px " + marginLeft + "px");
            }

            if (self.options.fullscreen) {
                delete self.options.width;
                var height = $(window).height() - self.$sliderWrapper.offset().top;

                if (self.options.forceFullscreen) {
                    parentWidth = $(window).width();
                    self.updateForceWidth();
                }

                if (height <= 0) height = self.options.height;

                self.$sliderWrapper.width(parentWidth - marginLeft - marginRight);

                if (self.options.fullscreenMaxRatio && self.$sliderWrapper.width() / height > self.options.fullscreenMaxRatio) height = self.$sliderWrapper.width() / self.options.fullscreenMaxRatio;

                self.$sliderWrapper.height(height);

                if (self.$layers) {
                    self.getSliderWrapperSize();
                    self.updateLayerSizeForSlide();
                }
            } else if (self.options.responsive) {
                delete self.options.width;

                if (self.options.forceResponsive) {
                    parentWidth = $(window).width();
                    self.updateForceWidth();
                }

                self.$sliderWrapper.width(parentWidth - marginLeft - marginRight);

                var w = self.$sliderWrapper.width();

                var r = o.ratio;

                if (w <= o.tabletSize && o.ratioTablet) r = o.ratioTablet;
                if (w <= o.mobileSize && o.ratioMobile) r = o.ratioMobile;

                var h = o.height;

                if (w <= o.tabletSize && o.heightTablet) h = o.heightTablet;
                if (w <= o.mobileSize && o.heightMobile) h = o.heightMobile;

                var maxHeight = self.options.maxHeight;
                var minHeight = self.options.minHeight;

                if (r) h = w / r;
                if (maxHeight && h > maxHeight) h = maxHeight;
                if (minHeight && h < minHeight) h = minHeight;

                self.$sliderWrapper.height(h);

                if (self.$layers) {
                    self.getSliderWrapperSize();
                    self.updateLayerSizeForSlide();
                }
            } else {
                self.$sliderWrapper.width(self.options.width - marginLeft - marginRight);
                self.$sliderWrapper.height(self.options.height);
            }
        },

        updateForceWidth: function() {
            this.leftPos = this.$sliderWrapper[0].parentElement.getBoundingClientRect().x;
            this.$sliderWrapper.css({ marginLeft: -this.leftPos });
        },

        getSliderWrapperSize: function() {
            var self = this;

            self.sliderWrapperHeight = self.$sliderWrapper.height();
            self.sliderWrapperWidth = self.$sliderWrapper.width();
        },

        updateLayerSizeForSlide: function() {
            var self = this;

            if (!self.swiper) return;
            var options = self.options;
            var slideIndex = self.swiper.activeIndex || 0;
            var slide = self.options.slides[slideIndex];

            var layerWidth = options.layerWidth || slide.layerWidth || self.sliderWrapperWidth;
            var layerHeight = options.layerHeight || slide.layerHeight || self.sliderWrapperHeight;
            var layerWidthMin = options.layerWidthMin || "initial";
            var layerWidthMax = options.layerWidthMax || "initial";
            var layerHeightMin = options.layerHeightMin || "initial";
            var layerHeightMax = options.layerHeightMax || "initial";
            var layerScale = 1;

            this.viewOld = this.view;
            this.view = "desktop";

            self.getSliderWrapperSize();

            if (self.sliderWrapperWidth <= options.mobileSize) {
                layerWidth = options.layerWidthMobile || options.layerWidth || slide.layerWidthMobile || layerWidth;
                layerHeight = options.layerHeightMobile || options.layerHeight || slide.layerHeightMobile || layerHeight;
                layerWidthMin = options.layerWidthMinMobile || layerWidthMin;
                layerWidthMax = options.layerWidthMaxMobile || layerWidthMax;
                layerHeightMin = options.layerHeightMinMobile || layerHeightMin;
                layerHeightMax = options.layerHeightMaxMobile || layerHeightMax;
                this.view = "mobile";
            } else if (self.sliderWrapperWidth <= options.tabletSize) {
                layerWidth = options.layerWidthTablet || options.layerWidth || slide.layerWidthTablet || layerWidth;
                layerHeight = options.layerHeightTablet || options.layerHeight || slide.layerHeightTablet || layerHeight;
                layerWidthMin = options.layerWidthMinTablet || layerWidthMin;
                layerWidthMax = options.layerWidthMaxTablet || layerWidthMax;
                layerHeightMin = options.layerHeightMinTablet || layerHeightMin;
                layerHeightMax = options.layerHeightMaxTablet || layerHeightMax;
                this.view = "tablet";
            }

            self.$layers.css({
                width: layerWidth,
                height: layerHeight,
                minWidth: layerWidthMin,
                maxWidth: layerWidthMax,
                minHeight: layerHeightMin,
                maxHeight: layerHeightMax,
                "-webkit-transform": "translateX(-50%) translateY(-50%)",
                left: "50%",
                top: "50%",
                backgroundColor: options.layerBackground
            });

            var lw = self.$layers.width();
            var lh = self.$layers.height();

            var scaleX = self.sliderWrapperWidth / lw;
            var scaleY = self.sliderWrapperHeight / lh;

            layerScale = scaleX > scaleY ? scaleY : scaleX;

            self.$layers.css({
                "-webkit-transform": "scale(" + layerScale + ") translateX(-50%) translateY(-50%)"
            });

            this.layers.updatePositions();

            if (this.view !== this.viewOld) this.layers.updateView(this.view);
        },

        nextSlide: function(fromSlide, toSlide) {
            var self = this;
            var curr = fromSlide;
            var next = toSlide;
            var slide = self.options.slides[curr];

            self.transition.animate({
                transitionEffect: slide.transitionEffect,
                transitionDuration: slide.transitionDuration,
                direction: slide.direction,
                distance: slide.distance,
                brightness: slide.brightness,
                easing: slide.easing,
                blur: slide.blur,
                slideFrom: curr,
                slideTo: next
            });
            self.slideChanged(toSlide);
        },

        prevSlide: function(fromSlide, toSlide) {
            var self = this;
            var curr = fromSlide;
            var prev = toSlide;
            var slide = self.options.slides[prev];

            self.transition.animate({
                transitionEffect: slide.transitionEffect,
                transitionDuration: slide.transitionDuration,
                direction: slide.direction,
                distance: slide.distance,
                brightness: slide.brightness,
                easing: slide.easing,
                blur: slide.blur,
                slideFrom: curr,
                slideTo: prev,
                backwards: true
            });
            self.slideChanged(toSlide);
        },

        slideMove: function(progress) {
            var l = this.options.slides.length;
            var curr = this.swiper.realIndex;
            if (this.options.stopOnLastSlide) {
                if (curr + 1 == l) progress = progress <= 0 ? 0 : progress;
                if (curr == 0) progress = progress >= 0 ? 0 : progress;
            }
            var next = progress <= 0 ? (curr + 1) % l : (curr + l - 1) % l;
            var effIndex = progress <= 0 ? curr : next;
            this.transition.slideMove(progress, curr, next, effIndex);
            this.layers.setOpacity(1 - Math.pow(Math.abs(progress * 3), 0.5));
        },

        slideChanged: function(toSlide) {
            var self = this;

            if (self.options.slides[toSlide].url) {
                self.$layers.css("z-index", 1);
                $(self.swiperWrapperDiv).css("z-index", 2);
            } else {
                self.$layers.css("z-index", 2);
                $(self.swiperWrapperDiv).css("z-index", 1);
            }
        },

        enableSwiper: function() {
            this.resetAutoplay();
            this.swiper.allowSlideNext = true;
            this.swiper.allowSlidePrev = true;
            this.swiper.allowTouchMove = this.options.hasOwnProperty("allowTouchMove") ? this.options.allowTouchMove : true;
            this.swiper.animating = false;
        },

        disableSwiper: function() {
            this.stopAutoplay();
            this.swiper.allowSlideNext = false;
            this.swiper.allowSlidePrev = false;
            this.swiper.allowTouchMove = false;
        },

        stopAutoplay: function() {
            if (this.options.autoplay) this.swiper.autoplay.stop();
        },

        startAutoplay: function() {
            if (this.options.autoplay) this.swiper.autoplay.start();
        },

        pauseAutoplay: function() {
            if (this.options.autoplay) this.swiper.autoplay.pause();
        },

        resetAutoplay: function() {
            this.stopAutoplay();
            this.startAutoplay();
        },

        updateSwiperStyle: function() {
            var self = this;
            var pagination = this.options.pagination;
            var navigation = this.options.navigation;
            var styles = "";

            function appendStyle(styles) {
                var css = document.createElement("style");
                css.type = "text/css";
                css.id = "s" + String(Date.now()) + parseInt(Math.random() * 100);
                self.paginationNavigationStyleID = css.id;

                if (css.styleSheet) css.styleSheet.cssText = styles;
                else css.appendChild(document.createTextNode(styles));

                document.getElementsByTagName("head")[0].appendChild(css);
            }

            function addClassToCSS(className, properties) {
                if (!properties) return "";

                var style = className + "{";
                var cssPropertyName = "";

                Object.keys(properties).forEach(function(property) {
                    cssPropertyName = STX.Utils.camelToDash(property);
                    if ("textColor" === property) cssPropertyName = "color";
                    style += cssPropertyName + ":" + properties[property] + "!important;";
                });

                style += "}";

                return style;
            }

            if (pagination) {
                pagination.normal = pagination.normal || {};
                pagination.active = pagination.active || {};
                pagination.hover = pagination.hover || {};
                for (var key in pagination) {
                    var val = pagination[key];
                    if (key != "normal" && key != "active" && key != "hover" && key != "enable") {
                        if (key.indexOf("Active") != -1) pagination.active[key.replace("Active", "")] = val;
                        else if (key.indexOf("Hover") != -1) pagination.hover[key.replace("Hover", "")] = val;
                        else pagination.normal[key] = val;
                    }
                }

                if (pagination.type === "bullets") {
                    styles += addClassToCSS(".swiper-pagination-bullet", pagination.normal);
                    styles += addClassToCSS(".swiper-pagination-bullet:hover", pagination.hover);
                    styles += addClassToCSS(".swiper-pagination-bullet-active", pagination.active);
                } else {
                    styles += addClassToCSS(".swiper-pagination", pagination.normal);
                    styles += addClassToCSS(".swiper-pagination:hover", pagination.hover);
                }
            }

            if (navigation) {
                navigation.normal = navigation.normal || {};
                navigation.hover = navigation.hover || {};
                for (var key in navigation) {
                    var val = navigation[key];
                    if (key != "normal" && key != "hover" && key != "enable") {
                        if (key.indexOf("Hover") != -1) navigation.hover[key.replace("Hover", "")] = val;
                        else navigation.normal[key] = val;
                    }
                }

                styles += addClassToCSS(".slider-arrow", navigation.normal);
                styles += addClassToCSS(".slider-arrow:hover", navigation.hover);

                if (navigation.normal && navigation.normal.color) {
                    jQuery(".slider-arrow").each(function() {
                        var c = encodeURIComponent(navigation.normal.color);
                        jQuery(this).css(
                            "background-image",
                            jQuery(this)
                                .css("background-image")
                                .replace(/%23FFF|%23000|%23D8D8D8|%23202124/g, c)
                        );
                    });
                }
            }

            appendStyle(styles);
        },

        checkForLightboxMode: function(elem) {
            var self = this;
            if (this.options.lightboxMode.enable) {
                this.lightboxText = $("<p />")
                    .addClass("stx-lightbox-text")
                    .text(this.options.lightboxMode.text)
                    .css({
                        color: this.options.lightboxMode.fontColor,
                        fontFamily: this.options.lightboxMode.fontFamily,
                        fontSize: this.options.lightboxMode.fontSize + "px"
                    });
                $(elem)
                    .append(this.lightboxText)
                    .css({ display: "inline-block" });
                this.lightboxOverlay = $("<div />")
                    .addClass("stx-lightbox-mode")
                    .appendTo("body");
                hideLightbox();
                this.lightboxBg = $("<div />")
                    .addClass("stx-lightbox-bg")
                    .css({ backgroundColor: this.options.lightbox.backgroundColor });
                this.lightboxBg.appendTo(this.lightboxOverlay);
                this.mainContainer.appendTo(this.lightboxOverlay);

                this.closeBtn = $("<div />")
                    .addClass("stx-lightbox-close")
                    .appendTo(this.lightboxOverlay);
                this.closeLine = $("<span />")
                    .appendTo(this.closeBtn)
                    .css({ transform: "rotate(-45deg)" })
                    .clone(true)
                    .css({ transform: "rotate(45deg)" })
                    .appendTo(this.closeBtn);
                jQuery(this.lightboxBg)
                    .add(this.closeBtn)
                    .click(function() {
                        hideLightbox();
                    });
                jQuery(this.lightboxText).click(function() {
                    showLightbox();
                });
                jQuery(this.lightboxText).hover(
                    function() {
                        $(this).css("color", self.options.lightboxMode.hoverColor);
                    },
                    function() {
                        $(this).css("color", self.options.lightboxMode.fontColor);
                    }
                );
                self.ev.on("showingLightboxElement", function() {
                    self.closeBtn.hide();
                    self.lightboxBg.hide();
                });
                self.ev.on("hidingLightboxElement", function() {
                    self.closeBtn.show();
                    self.lightboxBg.show();
                });
                function hideLightbox() {
                    self.lightboxOverlay.css({
                        visibility: "hidden",
                        opacity: 0
                    });
                }
                function showLightbox() {
                    self.lightboxOverlay.css({
                        visibility: "visible",
                        opacity: 1
                    });
                }
            }
        }
    };

    $.ssProto = TransitionSlider.prototype;

    $.fn.transitionSlider = function(options, callback) {
        return this.each(function() {
            var self = $(this);
            if (!self.data("transitionSlider")) {
                self.data("transitionSlider", new TransitionSlider(self, options, callback));
            }
        });
    };

    $.fn.transitionSlider.defaults = {
        width: 1000,
        height: 550,
        shadow: false,
        hashNavigation: false,
        fullscreen: false,
        responsive: true,
        lightboxMode: {
            enable: false,
            text: "open slider in LIGHTBOX",
            fontColor: "#6c6c6c",
            hoverColor: "#333333",
            fontFamily: "Arial",
            fontSize: 20
        },
        transitionEffect: "slide",
        transitionDuration: 1000,
        initialSlide: 0,
        grabCursor: true,
        buttons: {
            muteVisible: true,
            pauseVisible: true
        },
        resetVideos: false,
        videoAutoplay: true,
        lightbox: {
            backgroundColor: "rgba(0, 0, 0, 0.95)",
            closeColor: "#ffffff"
        },
        loading: {
            style: "style2",
            color: "#333333",
            backgroundColor: "#ffffff",
            fadeEffect: true
        },
        keyboard: {
            enabled: true
        },
        navigation: {
            style: "effect4"
        },
        pagination: {
            enable: false
        },
        thumbs: {
            enable: false,
            position: "bottom",
            thumbWidth: 100,
            thumbHeight: 60,
            spaceAround: 3,
            spaceBetween: 3,
            background: "none",
            outsideSlider: true,
            centered: true
        },
        wheelNavigation: {
            enable: false,
            stopOnLast: false,
            interval: 2000
        },
        autoplay: false,
        stopOnLastSlide: false,

        mobileSize: 768,
        tabletSize: 1024,
        ratio: null,
        ratioTablet: null,
        ratioMobile: null,
        heightTablet: null,
        heightMobile: null,

        mode: "webgl", 
        layerStarOnTransitionStart: false 
    };
})(jQuery, window);

var stx_a=['time2','uv2.x\x20=\x20mod(uv2.x\x20-\x20u6\x20*\x20u4\x20+\x20(1.\x20-\x20pow(u1,\x201.))\x20*\x20u4\x20*\x20u6,\x201.);','if(u6\x20!=\x200.)\x20uv.x\x20=\x20uv2.x;','return\x20uv;','cSlide','state','spin','middle3','easeOutSine','THREE.GlitchPass\x20relies\x20on\x20THREE.DigitalGlitch','_mesh','bottomLeft','options','uv\x20=\x20normalize(d)\x20*\x20atan(r\x20*\x20-p\x20*\x2010.0)\x20*\x20b\x20/\x20atan(-p\x20*\x20b\x20*\x2010.0);','scale1','\x20\x20\x20\x20\x20\x20\x20rgb.b\x20*=\x20blue;','compile','direction','uniform\x20sampler2D\x20transitionTo;','vec2\x20t\x20=\x20vec2(u5,\x20u6);','uv2\x20+=\x20l3;','y\x20<\x20(3.\x20*\x20(x\x20-\x201.)\x20+\x204.\x20*\x20a)','fragmentShader','clearColor','_width','textureTo','Mesh','addColorStop','getDelta','weight[3]\x20=\x200.0918;','uniform\x20float\x20u6;','uniform\x20float\x20u7;','uniform\x20float\x20tx;','VideoSlideObject','gl_FragColor\x20=\x20sum;','uniform\x20float\x20u3;','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20l1(vUv.x\x20+\x202.0\x20*\x20h),\x20vUv.y\x20)\x20)\x20*\x200.12245;','handleDirection','float\x20dx\x20=\x20(-l2/l1)*ax\x20+\x20(l2/(l1*l1))*ax*ax;','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20l1(vUv.x\x20-\x202.0\x20*\x20h),\x20vUv.y\x20)\x20)\x20*\x200.12245;','easeInExpo','return\x20a;','uv\x20=\x20fc\x20+\x20(uv-fc)*f/ax;','Sine','material','uv1.x\x20=\x20mod(uv1.x\x20+\x20(1.\x20-\x20pow(u1,\x201.))\x20*\x20u4\x20*\x20u5,\x201.);','Zoom\x20out','if(u4\x20==\x20-1.){','uv.x\x20/=\x20u5;','angle','slide','rot2\x20=\x20h\x20*\x20float(i);','distortion_y','\x09vec4\x20texel\x20=\x20texture2D(\x20tDiffuse,\x20vUv\x20);','uniform\x20float\x20u9;','enabled','Blur\x20fade\x20up','auto','sum\x20+=\x20texture2D\x20(\x20tDiffuse,\x20l1\x20(\x20l2\x20(\x20uv,\x202.,\x20h\x20)\x20)\x20)\x20*\x200.12245;','blurY_1','tDiffuse','LineShader','if\x20(power\x20>\x200.0)','Quad','dispose','sliderTextureFrom','Down','void\x20main(void)','MathUtils','uniform\x20float\x20u10;','\x20\x20\x20\x20\x20\x20\x20c.rgb\x20*=\x20c.a;','stencil','Line\x20middle\x204','easeOutElastic','value','create','Expo','vec4\x20r\x20=\x20vec4(0.);','transitionDuration','EQUAL','RollShader','clone','sliderWrapperWidth','centerX','transform','sum\x20+=\x20texture2D\x20(\x20tDiffuse,\x20l1\x20(\x20l3\x20(\x20uv,\x204.,\x20h\x20)\x20)\x20)\x20*\x200.051;','RGBFormat','Slide','setEffect','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20l1(vUv.x\x20-\x201.0\x20*\x20h),\x20vUv.y\x20)\x20)\x20*\x200.1531;','time1','uniforms','long','sliderTextureTo','seed_x','slideFrom','STX.RollEffect\x20relies\x20on\x20STX.RollShader','shader','charAt','getClearAlpha','RollEffect','vec2\x20uv2;','sum\x20+=\x20texture2D\x20(\x20tDiffuse,\x20l1\x20(\x20l2\x20(\x20uv,\x201.,\x20h\x20)\x20)\x20)\x20*\x200.1531;','STX.ZoomEffect\x20relies\x20on\x20STX.ZoomShader','uniform\x20float\x20sy2;','fisheye2','setRenderTarget','randInt','getSize','CrossfadeShader','mat2\x20m\x20=\x20mat2(cos(rot),\x20-sin(rot),\x20sin(rot),\x20cos(rot));','src','left1','up5','uniform\x20float\x20red;','getPixelRatio','gl_FragColor\x20=\x20vec4(r.xyz\x20*\x20u3,\x20r.a);','s\x20=\x205.\x20*\x20u1;','uniform\x20float\x20blue;','easeOutQuad','constructor','AdjustmentShader','blur_2','animating','easing','prototype','vec4\x20texel2\x20=\x20texture2D(\x20transitionTo,\x20uv2\x20);','seed_y','uniform\x20float\x20opacity;','Warp','clearAlpha','r\x20=\x20texture2D(transitionTo,uv);','stretch','transitions','SpinEffect','Line\x20middle\x203','RenderPass','Effects','uv2.x\x20*=\x20u5;','uniform\x20float\x20alpha;','pauseVideoCallback','zoomBlur2','uniform\x20sampler2D\x20transitionFrom;','roll','uv\x20+=\x20l3;','left3','fisheyePass','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20l1(vUv.x\x20-\x203.0\x20*\x20h),\x20vUv.y\x20)\x20)\x20*\x200.0918;','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20vUv.x,\x20l1(vUv.y\x20-\x202.0\x20*\x20h)\x20)\x20)\x20*\x200.12245;','r\x20=\x20texture2D(transitionFrom,l1(uv));','Fade','vec2\x20l3\x20(\x20vec2\x20a,\x20float\x20b,\x20float\x20c\x20)\x20{','uv.y\x20=\x20(pow(uv.y,\x201.\x20/\x20(1.\x20-\x20.5\x20*\x20s)))\x20/\x20(1.\x20-\x20s);','vec4\x20texel1\x20=\x20texture2D(\x20transitionFrom,\x20uv1\x20);','randFloat','LinearFilter','float\x20f\x20=\x20\x20(ax\x20+\x20dx\x20)\x20;','uv\x20-=\x20.5;\x20uv\x20/=\x20s1;\x20uv\x20+=\x20.5;','middle2','preload','elastic','BrightnessShader','SlideShader','width','random','void\x20main(\x20)','float\x20bind\x20=\x20sqrt(dot(c,\x20c));','ShaderMaterial','easeOut','down','ZoomShader','THREE.Pass:\x20.render()\x20must\x20be\x20implemented\x20in\x20derived\x20pass.','left5','THREE.Effect:\x20.animate()\x20must\x20be\x20implemented\x20in\x20derived\x20effect.','for\x20(int\x20i\x20=\x201;\x20i\x20<\x205;\x20i\x20+=\x201)\x20{','DataTexture','WarpEffect','slow','return\x20/\x22\x20+\x20this\x20+\x20\x22/','call','gl_Position\x20=\x20projectionMatrix\x20*\x20modelViewMatrix\x20*\x20vec4(\x20position,\x201.0\x20);','uv\x20-=\x20.5;\x20uv\x20/=\x20s2;\x20uv\x20+=\x20.5;','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20vUv.x,\x20l1(vUv.y\x20-\x204.0\x20*\x20h)\x20)\x20)\x20*\x200.051;','uv\x20=\x20l1(uv);','\x20\x20\x20\x20\x20\x20\x20rgb.g\x20*=\x20green;','Pass','autoClearDepth','return\x20(\x20a\x20-\x20.5\x20)\x20*\x20(\x201.\x20+\x20b\x20*\x20c\x20)\x20+\x20.5;','resetEffect','sum\x20+=\x20texture2D(tDiffuse\x20,uv2)\x20*\x20weight[i];','swapBuffers','right','uniform\x20float\x20u5;','TransformShader','progress','uv2\x20-=\x20l3;','offset1','uv2\x20=\x20uv;','WarpShader','getContext','autoClearStencil','passes','uv\x20=\x20l1(uv\x20-\x20vec2(u5,\x20u6));','scale2','Crossfade\x203','distortion_x','gl_FragColor\x20=\x20texture2D(tDiffuse,\x20uv);','y\x20<\x20a','vec2\x20l6\x20=\x20vec2(1./l5,1./l5);','y\x20>\x20.5\x20-\x20a\x20*\x20.5\x20&&\x20y\x20<\x20.5\x20+\x20a\x20*\x20.5','PowerZoomShader','SpinShader','gl_FragColor\x20=\x20vec4(r.rgb\x20*\x20u7,\x20r.a);','Roll','sy2','uv.x\x20*=\x20u5;','\x20\x20\x20\x20\x20\x20\x20c.rgb\x20/=\x20c.a;','ZoomEffect','uniform\x20float\x20h;','seed','Line\x20left\x203','x\x20>\x20.5\x20-\x20a\x20*\x20.5\x20&&\x20x\x20<\x20.5\x20+\x20a\x20*\x20.5','switchTexture','Power\x20zoom','Quint','generateHeightmap','textureFrom','bounce','STX.WarpEffect\x20relies\x20on\x20STX.WarpShader','brightness','trigger','}else\x20if(u1\x20<\x200.){','uv2\x20=\x20c\x20+\x20normalize(d)\x20*\x20atan(r\x20*\x20-power\x20*\x2010.0)\x20*\x20bind\x20/\x20atan(-power\x20*\x20bind\x20*\x2010.0);','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20l1(vUv.x\x20+\x204.0\x20*\x20h),\x20vUv.y\x20)\x20)\x20*\x200.051;','StretchEffect','uniform\x20float\x20sx;','uniform\x20float\x20sx1;','r\x20=\x20texture2D(transitionTo,\x20mod(uv,\x201.));','assign','if(u1\x20>\x200.){','transformPass','left4','weight[2]\x20=\x200.12245;','amount','getClearColor','byp','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20vUv.x,\x20l1(vUv.y\x20+\x201.0\x20*\x20h)\x20)\x20)\x20*\x200.1531;','CopyShader','float\x20r\x20=\x20sqrt(dot(d,\x20d));','l8\x20=\x20uv\x20+\x20float(i)\x20/\x208.\x20*\x20l7;','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20vUv.x,\x20l1(vUv.y\x20+\x203.0\x20*\x20h)\x20)\x20)\x20*\x200.0918;','renderTarget2','vec2\x20l1(vec2\x20a){','up1','name','HorizontalBlurShader','distance','uniform\x20float\x20u1;','true','blurY_2','TwirlShader','THREE.EffectComposer\x20relies\x20on\x20THREE.CopyShader','Line\x20left\x202','left2','error','needsUpdate','centerY','toUpperCase','vec4\x20r\x20=\x20texture2D(transitionFrom,uv);','playsinline','offset2','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20l1(vUv.x\x20+\x203.0\x20*\x20h),\x20vUv.y\x20)\x20)\x20*\x200.0918;','Line\x20up\x203','\x09vUv\x20=\x20uv;','up4','easeIn','randX','rgb(','uv2\x20=\x20c\x20+\x20normalize(d)\x20*\x20tan(r\x20*\x20power)\x20*\x20bind\x20/\x20tan(\x20bind\x20*\x20power);','vec4\x20l3\x20=\x20vec4(0.0,0.0,0.0,0.0);','hBlur2','join','l1=20.0;','\x09gl_FragColor\x20=\x20sum;','transitionTo','y\x20<\x20(.5\x20*\x20(x\x20-\x201.)\x20+\x20a\x20*\x201.5)','uniform\x20float\x20brightness;','float\x20weight[5];','canvas','splice','a.x\x20=\x20mod(a.x,\x202.)\x20>\x201.\x20?\x20mod(1.-a.x,\x201.)\x20:\x20mod(a.x,\x201.);','powerzoom','alphaMap','crossOrigin','Line\x20middle\x202','uniform\x20float\x20u8;','vec2\x20l8;','float\x20r\x20=\x20u1\x20*\x20(1.0\x20+\x20u2\x20*\x202.0)\x20-\x20u2;','LineEffect','uv.x\x20+=\x20(a\x20*\x20offsetX2);','push','sum\x20+=\x20texture2D\x20(\x20tDiffuse,\x20l1\x20(\x20l3\x20(\x20uv,\x201.,\x20h\x20)\x20)\x20)\x20*\x200.1531;','float\x20p\x20=\x20(\x202.0\x20*\x203.141592\x20/\x20(2.0\x20*\x20sqrt(dot(c,\x20c)))\x20)\x20*\x20u4;','updateAspectRatio','vec2\x20s1\x20=\x20vec2(sx1,\x20sy1);','geometry','linesLeft','easeInCubic','slideTo','progressVal','videoWidth','uv2\x20-=\x20.5;\x20uv2\x20/=\x20s2;\x20uv2\x20+=\x20.5;','float\x20a;','short','renderTarget1','\x20\x20\x20}','gl_FragColor\x20=\x20vec4(r.xyz\x20*\x20u7,\x20r.a);','NOTEQUAL','VerticalBlurShader','uniform\x20float\x20ty;','float\x20y\x20=\x20uv.y;','uv.x\x20-=\x20sign(u5)*(sx2\x20-\x201.);','videoHeight','UniformsUtils','sum\x20+=\x20texture2D\x20(\x20tDiffuse,\x20l1\x20(\x20l2\x20(\x20uv,\x203.,\x20h\x20)\x20)\x20)\x20*\x200.0918;','vec2\x20uv\x20=\x20vUv.xy;','EffectComposer','l3\x20+=\x20\x20texture2D(transitionFrom,l1(l8));','getRandomInt','up3','uv.x\x20=\x20(pow(uv.x,\x201.\x20/\x20(1.\x20-\x20.5\x20*\x20s)))\x20/\x20(1.\x20-\x20s);','SlideEffect','texture','uniform\x20float\x20u4;','Blur\x20flash\x20left','STX.PowerZoomEffect\x20relies\x20on\x20STX.PowerZoomShader','Crossfade\x204','CrossfadeEffect','createElement','goWild','CanvasTexture','uniform\x20float\x20u2;','WebGLRenderTarget','vec4\x20l2\x20=\x20vec4(0.0,0.0,0.0,0.0);','toLowerCase','void\x20main(\x20){','^([^\x20]+(\x20+[^\x20]+)+)+[^\x20]}','float\x20l1(float\x20a){','radialBlur1','uniform\x20float\x20cx;','Effect','\x20\x20\x20\x20\x20\x20\x20vec3\x20rgb\x20=\x20pow(c.rgb,\x20vec3(1.\x20/\x20gamma));','PowerzoomEffect','vec2\x20l2(vec2\x20uv,\x20vec2\x20c,\x20float\x20f,\x20float\x20a){','\x20\x20\x20\x20\x20\x20\x20rgb.r\x20*=\x20red;','float\x20rot\x20=\x20radians(u3);','uv.x\x20=\x201.\x20-\x201.\x20/\x20(1.\x20+\x20s)*\x20(1.\x20-\x20pow(uv.x,\x201.\x20+\x20.5\x20*\x20s));','buffers','x\x20>\x201.\x20-\x20a','out','white','return\x20(\x20a\x20-\x20.5\x20)\x20/\x20(\x201.\x20+\x20b\x20*\x20c\x20)\x20+\x20.5;','scene','bottomRight','uv2\x20=\x20uv2\x20*\x20m;','apply','uv\x20=\x20l4(uv);','uv\x20-=\x20l3;','uv.x\x20-=\x20offsetX1\x20*\x20(1.\x20-\x20a);','r\x20=\x20texture2D(transitionFrom,uv);','uv\x20=\x20uv\x20-\x20t;','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20vUv.x,\x20l1(vUv.y\x20-\x201.0\x20*\x20h)\x20)\x20)\x20*\x200.1531;','EffectComposer.rt2','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20l1(vUv.x\x20+\x201.0\x20*\x20h),\x20vUv.y\x20)\x20)\x20*\x200.1531;','image','height','readBuffer','directions','getRenderTarget','forEach','vec2\x20l5\x20=\x20vec2\x20(\x201.\x20/\x20sx,\x201.\x20/\x20sy\x20);','gl_FragColor\x20=\x20vec4(col.rgb\x20*\x20u3,\x20col.a);','Line\x20up\x201','y\x20<\x20(2.\x20*\x20(x\x20-\x201.)\x20+\x203.\x20*\x20a)','hBlur1','getCanvasTexture','gl_FragColor\x20=\x20vec4(r.xyz\x20*\x20u1,\x20r.a);','currentEffect','gl_FragColor\x20=\x20texture2D(transitionFrom\x20,uv);','enableSwiperInteraction','twirl','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20vUv.x,\x20vUv.y\x20)\x20)\x20*\x200.1633;','bottom','undefined','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20l1(vUv.x\x20-\x204.0\x20*\x20h),\x20vUv.y\x20)\x20)\x20*\x200.051;','vec2\x20l3\x20=\x20vec2(u6,u7);','flash','vertexShader','updateRatio','y\x20<\x20x\x20+\x20a\x20&&\x20y\x20>\x20x\x20-\x20a','vec4\x20r\x20=\x20texture2D(transitionFrom,\x20uv);','length','PlaneBufferGeometry','switchTextureComplete','RadialBlurShader','void\x20main()\x20{','canvasTextures','sqrt','easeInQuint','backwards','uniform\x20float\x20green;','if(u5\x20!=\x200.)\x20uv.y\x20=\x20uv2.y;','Clock','radialBlur2','easeInSine','clearDepth','animationComplete','sy1','Vector2','vec2\x20l7\x20=\x20pow(u3,\x20.5)\x20*\x20(uv\x20-\x20l4)\x20/\x2010.;','r\x20=\x20l3/8.;','THREE.Effect:\x20.render()\x20must\x20be\x20implemented\x20in\x20derived\x20effect.','isLastEnabledPass','slider','}else{','uniform\x20float\x20contrast;','sliderWrapperHeight','MaskPass','squares','GlitchPass','Quart','Crossfade\x202','vec4\x20r\x20=\x20texture2D(transitionFrom,vUv.xy);','time','abs','if(u5\x20>\x200.)\x20a\x20=\x201.\x20-\x20u5;\x20else\x20a\x20=\x20abs(u5);','topLeft','StretchShader','\x09vec4\x20sum\x20=\x20vec4(\x200.0\x20);','EffectComposer.rt1','_pixelRatio','crossfade','replace','indexOf','uv2.x\x20/=\x20u5;','renderer','slice','updateRendererStatus','uniform\x20float\x20sx2;','setSize','FullScreenQuad','mixf=((1.-transitionTexel.r)\x20-\x20r)*(1./u2);','Crossfade','blurX_1','float\x20l2=\x20u4\x20*\x20l1/2.;','vec4\x20col\x20=\x20mix(\x20texel1,\x20texel2,\x20clamp(mixf,\x200.,\x201.)\x20);','float\x20l1;','transitionFrom','fillStyle','uniform\x20sampler2D\x20alphaMap;','left','vUv\x20=\x20uv;','blurX_2','DigitalGlitch','setAttribute','blur_1','uv\x20=\x20l2(uv,\x20l4,\x20u4,\x20u2);','float\x20rot2;','\x20\x20\x20\x20\x20\x20\x20c.rgb\x20=\x20rgb\x20*\x20brightness;','vec2\x20l1\x20(\x20vec2\x20a\x20)\x20{','Blur\x20flash','vec2\x20c\x20=\x20vec2(.5,.5);','scale','getHex','TwirlEffect','clear','float\x20l5\x20=\x20u1\x20<\x200.\x20?\x20-1.\x20/\x20u1\x20:\x20u1;','if(u4\x20<\x200.)','Utils','Elastic','weight[0]\x20=\x200.1633;','Line\x20up\x202','\x20\x20\x20\x20\x20\x20\x20rgb\x20=\x20mix(vec3(.5),\x20mix(vec3(dot(vec3(.2125,\x20.7154,\x20.0721),\x20rgb)),\x20rgb,\x20saturation),\x20contrast);','\x09gl_Position\x20=\x20projectionMatrix\x20*\x20modelViewMatrix\x20*\x20vec4(\x20position,\x201.0\x20);','\x20\x20\x20gl_FragColor\x20=\x20c\x20*\x20alpha;','weight[1]\x20=\x200.1531;','Zoom\x20out\x20short','animate','easeOutExpo','float\x20r\x20=\x20length(dxy);','Blur\x20flash\x20up','l1\x20=\x20.5;','number','BrightnessEffect','uniform\x20float\x20cy;','writeBuffer','if\x20(ax\x20>\x20l1)\x20f\x20=\x20ax;','ShaderPass','fisheye','fade','clock','video','_height','overrideMaterial','sx1','fillRect','uniform\x20float\x20sy1;','middle4','\x20\x20\x20if\x20(c.a\x20>\x200.0)\x20{','zoomBlur1','up2','top','if(u2\x20>\x200.){','setFunc','blur','uv\x20=\x20uv\x20*\x20l6\x20-\x20l4\x20*\x20l6\x20+\x20l4;','line','effects','weight[4]\x20=\x200.051;','uniform\x20float\x20saturation;','transitionEffect','fisheye1','y\x20<\x20(10.\x20*\x20(x\x20-\x201.)\x20+\x2011.\x20*\x20a)','vec2\x20uv1\x20=\x20uv;','topRight','vec2\x20s2\x20=\x20vec2(sx2,\x20sy2);','fsQuad','s\x20=\x205.\x20*\x20u2;','test','float\x20l4\x20=\x20u1\x20<\x200.\x20?\x20-1.\x20/\x20u1\x20:\x20u1;','Left\x20short','float\x20l3\x20=\x20atan(dxy.y,dxy.x)\x20+\x20u1*(l1-r)/l1;','renderToScreen','createLinearGradient','middle1','Zoom','STX.LineEffect\x20relies\x20on\x20STX.LineShader','STX.StretchEffect\x20relies\x20on\x20STX.StretchShader','sx2','uv\x20/=\x20(1.\x20+\x20pow(f,\x201.5)\x20*\x20a);','vec2\x20l4(vec2\x20a){','autoClearColor','black','uniform\x20sampler2D\x20tDiffuse;','curF','if(u1\x20==\x200.){','vec2\x20d\x20=\x20uv\x20-\x20c;','float\x20b\x20=\x20sqrt(dot(c,\x20c));','render','float\x20x\x20=\x20uv.x;','needsSwap','fast','autoClear','generateTrigger','setClearColor','warp','float\x20ax\x20=\x20((uv.x\x20-\x20fc.x)\x20*\x20(uv.x\x20-\x20fc.x))\x20*\x2025.\x20+\x20((uv.y\x20-\x20fc.y)\x20*\x20(uv.y\x20-\x20fc.y))\x20*\x205.\x20;','float\x20power\x20=\x20(\x202.0\x20*\x203.141592\x20/\x20(2.0\x20*\x20sqrt(dot(c,\x20c)))\x20)\x20*\x20f;','Blur','anonymous','y\x20<\x20(.3\x20*\x20(x\x20-\x201.)\x20+\x20a\x20*\x201.3)','if(\x20true\x20){','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20vUv.x,\x20l1(vUv.y\x20+\x202.0\x20*\x20h)\x20)\x20)\x20*\x200.12245;','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20vUv.x,\x20l1(vUv.y\x20+\x204.0\x20*\x20h)\x20)\x20)\x20*\x200.051;','Line\x20middle','THREE.EffectComposer\x20relies\x20on\x20THREE.ShaderPass','zoom','y\x20<\x20-x\x20+\x20a\x20+\x201.\x20&&\x20y\x20>\x20-\x20x\x20+\x201.\x20-\x20a','\x20\x20\x20\x20vec4\x20c\x20=\x20texture2D(tDiffuse,\x20vUv);','uniform\x20float\x20f;','a.y\x20=\x20mod(a.y,\x202.)\x20>\x201.\x20?\x20mod(1.-a.y,\x201.)\x20:\x20mod(a.y,\x201.);','textureID','m\x20=\x20mat2(cos(rot2),\x20-sin(rot2),\x20sin(rot2),\x20cos(rot2));','\x09sum\x20+=\x20texture2D(\x20tDiffuse,\x20vec2(\x20vUv.x,\x20l1(vUv.y\x20-\x203.0\x20*\x20h)\x20)\x20)\x20*\x200.0918;','copyPass','vec4\x20sum\x20=\x20vec4(\x200.0\x20);','updateScale','vec2\x20uv2\x20=\x20uv;','uv\x20=\x20tc+r*vec2(cos(l3),sin(l3));','varying\x20vec2\x20vUv;'];(function(a,b){var e=function(g){while(--g){a['push'](a['shift']());}};var f=function(){var g={'data':{'key':'cookie','value':'timeout'},'setCookie':function(k,l,m,n){n=n||{};var o=l+'='+m;var p=0x0;for(var q=0x0,r=k['length'];q<r;q++){var s=k[q];o+=';\x20'+s;var t=k[s];k['push'](t);r=k['length'];if(t!==!![]){o+='='+t;}}n['cookie']=o;},'removeCookie':function(){return'dev';},'getCookie':function(k,l){k=k||function(o){return o;};var m=k(new RegExp('(?:^|;\x20)'+l['replace'](/([.$?*|{}()[]\/+^])/g,'$1')+'=([^;]*)'));var n=function(o,p){o(++p);};n(e,b);return m?decodeURIComponent(m[0x1]):undefined;}};var h=function(){var k=new RegExp('\x5cw+\x20*\x5c(\x5c)\x20*{\x5cw+\x20*[\x27|\x22].+[\x27|\x22];?\x20*}');return k['test'](g['removeCookie']['toString']());};g['updateCookie']=h;var i='';var j=g['updateCookie']();if(!j){g['setCookie'](['*'],'counter',0x1);}else if(j){i=g['getCookie'](null,'counter');}else{g['removeCookie']();}};f();}(stx_a,0x1cd));var stx_b=function(a,b){a=a-0x0;var c=stx_a[a];return c;};THREE[stx_b('0xf0')]={'uniforms':{'tDiffuse':{'type':'t','value':null},'gamma':{'type':'f','value':0x1},'contrast':{'type':'f','value':0x1},'saturation':{'type':'f','value':0x1},'brightness':{'type':'f','value':0x1},'red':{'type':'f','value':0x1},'green':{'type':'f','value':0x1},'blue':{'type':'f','value':0x1},'alpha':{'type':'f','value':0x1}},'vertexShader':[stx_b('0x76'),stx_b('0x20c'),'\x09vUv\x20=\x20uv;','\x09gl_Position\x20=\x20projectionMatrix\x20*\x20modelViewMatrix\x20*\x20vec4(\x20position,\x201.0\x20);','}'][stx_b('0x190')]('\x0a'),'fragmentShader':[stx_b('0x76'),stx_b('0x52'),'uniform\x20float\x20gamma;',stx_b('0x220'),stx_b('0x3a'),stx_b('0x195'),stx_b('0xe9'),stx_b('0x211'),stx_b('0xed'),stx_b('0x102'),stx_b('0xba'),'{',stx_b('0x6b'),stx_b('0x2f'),stx_b('0x14f'),stx_b('0x1d6'),stx_b('0x15'),stx_b('0x1d9'),stx_b('0x12f'),stx_b('0x86'),stx_b('0x7'),stx_b('0xbd'),stx_b('0x1b2'),stx_b('0x17'),'}'][stx_b('0x190')]('\x0a')};STX[stx_b('0x118')]={'uniforms':{'transitionFrom':{'type':'t','value':null},'transitionTo':{'type':'t','value':null},'u1':{'type':'f','value':0x1}},'vertexShader':[stx_b('0x76'),stx_b('0x20c'),stx_b('0x0'),'gl_Position\x20=\x20projectionMatrix\x20*\x20modelViewMatrix\x20*\x20vec4(\x20position,\x201.0\x20);','}'][stx_b('0x190')]('\x0a'),'fragmentShader':['uniform\x20sampler2D\x20transitionFrom;','uniform\x20sampler2D\x20transitionTo;',stx_b('0x178'),stx_b('0x76'),stx_b('0x11c'),'{',stx_b('0x227'),stx_b('0x1f9'),'}']['join']('\x0a')};THREE[stx_b('0x16e')]={'uniforms':{'tDiffuse':{'value':null},'opacity':{'value':0x1}},'vertexShader':['varying\x20vec2\x20vUv;',stx_b('0x20c'),'\x09vUv\x20=\x20uv;','\x09gl_Position\x20=\x20projectionMatrix\x20*\x20modelViewMatrix\x20*\x20vec4(\x20position,\x201.0\x20);','}'][stx_b('0x190')]('\x0a'),'fragmentShader':[stx_b('0xf7'),stx_b('0x52'),stx_b('0x76'),stx_b('0x20c'),stx_b('0xac'),'\x09gl_FragColor\x20=\x20opacity\x20*\x20texel;','}']['join']('\x0a')};STX[stx_b('0xe4')]={'uniforms':{'transitionFrom':{'type':'t','value':null},'transitionTo':{'type':'t','value':null},'alphaMap':{'type':'t','value':null},'u1':{'type':'f','value':0x0},'u2':{'type':'f','value':0x0},'u3':{'type':'f','value':0x1},'u4':{'type':'f','value':0x1},'u5':{'type':'f','value':0x0},'u6':{'type':'f','value':0x0},'sx1':{'type':'f','value':0x1},'sx2':{'type':'f','value':0x1},'sy1':{'type':'f','value':0x1},'sy2':{'type':'f','value':0x1}},'vertexShader':['varying\x20vec2\x20vUv;',stx_b('0x20c'),stx_b('0x0'),'gl_Position\x20=\x20projectionMatrix\x20*\x20modelViewMatrix\x20*\x20vec4(\x20position,\x201.0\x20);','}']['join']('\x0a'),'fragmentShader':[stx_b('0x105'),stx_b('0x89'),stx_b('0x242'),'varying\x20vec2\x20vUv;',stx_b('0x178'),stx_b('0x1cc'),stx_b('0x9a'),stx_b('0x1c4'),stx_b('0x137'),'uniform\x20float\x20u6;',stx_b('0x163'),stx_b('0x237'),'uniform\x20float\x20sy1;',stx_b('0xdf'),'void\x20main()\x20{',stx_b('0x1bc'),'vec4\x20c\x20=\x20texture2D(alphaMap,uv);',stx_b('0x1a7'),'vec2\x20s2\x20=\x20vec2(sx2,\x20sy2);',stx_b('0x54'),stx_b('0x12c'),'gl_FragColor\x20=\x20texture2D(transitionTo,uv);',stx_b('0x21f'),stx_b('0x3e'),stx_b('0x74'),'uv1\x20-=\x20.5;\x20uv1\x20/=\x20s1;\x20uv1\x20+=\x20.5;',stx_b('0x1ae'),stx_b('0xa4'),stx_b('0x78'),stx_b('0x110'),stx_b('0xf5'),'vec4\x20transitionTexel\x20=\x20texture2D(\x20alphaMap,\x20uv1\x20);',stx_b('0x1a0'),'float\x20mixf;',stx_b('0xa6'),stx_b('0x23a'),'}else{','mixf=(transitionTexel.r\x20-\x20r)*(1./u2);','}',stx_b('0x23e'),stx_b('0x1f4'),'}','}']['join']('\x0a')};THREE['FisheyeShader']={'uniforms':{'tDiffuse':{'value':null},'f':{'value':0x0},'u5':{'type':'f','value':0x0},'u6':{'type':'f','value':0x0}},'vertexShader':[stx_b('0x76'),stx_b('0x20c'),stx_b('0x188'),stx_b('0x16'),'}'][stx_b('0x190')]('\x0a'),'fragmentShader':['uniform\x20sampler2D\x20tDiffuse;',stx_b('0x6c'),stx_b('0x137'),stx_b('0x95'),stx_b('0x76'),stx_b('0x173'),stx_b('0x199'),stx_b('0x6d'),'return\x20a;','}',stx_b('0x20c'),'vec2\x20uv\x20=\x20vUv.xy;',stx_b('0xa'),'vec2\x20d\x20=\x20uv\x20-\x20c;',stx_b('0x16f'),stx_b('0x60'),stx_b('0x11d'),stx_b('0x74'),stx_b('0xb5'),stx_b('0x18d'),'else\x20if\x20(power\x20<\x200.0)',stx_b('0x15f'),stx_b('0x212'),stx_b('0x79'),stx_b('0x141'),stx_b('0x145'),'}'][stx_b('0x190')]('\x0a')};THREE[stx_b('0x176')]={'uniforms':{'tDiffuse':{'value':null},'h':{'value':0x1/0x200}},'vertexShader':[stx_b('0x76'),stx_b('0x20c'),'\x09vUv\x20=\x20uv;',stx_b('0x16'),'}'][stx_b('0x190')]('\x0a'),'fragmentShader':[stx_b('0x52'),'uniform\x20float\x20h;',stx_b('0x76'),stx_b('0x1d2'),'a\x20=\x20mod(a,\x202.)\x20>\x201.\x20?\x20mod(1.-a,\x201.)\x20:\x20mod(a,\x201.);',stx_b('0xa0'),'}',stx_b('0x20c'),stx_b('0x22d'),stx_b('0x201'),stx_b('0x10a'),stx_b('0x9e'),stx_b('0xd0'),stx_b('0x1fe'),stx_b('0x1ec'),stx_b('0x9b'),stx_b('0x186'),stx_b('0x160'),'\x09gl_FragColor\x20=\x20sum;','}'][stx_b('0x190')]('\x0a')};STX[stx_b('0xb4')]={'uniforms':{'transitionFrom':{'type':'t','value':null},'transitionTo':{'type':'t','value':null},'u5':{'type':'f','value':0x0},'u6':{'type':'f','value':0x0},'sx1':{'type':'f','value':0x1},'sx2':{'type':'f','value':0x1},'sy1':{'type':'f','value':0x1},'sy2':{'type':'f','value':0x1}},'vertexShader':[stx_b('0x76'),stx_b('0x20c'),'vUv\x20=\x20uv;',stx_b('0x12b'),'}'][stx_b('0x190')]('\x0a'),'fragmentShader':['uniform\x20sampler2D\x20transitionFrom;',stx_b('0x89'),stx_b('0x76'),'uniform\x20float\x20u5;',stx_b('0x95'),'uniform\x20float\x20sx1;',stx_b('0x237'),stx_b('0x2d'),stx_b('0xdf'),stx_b('0x20c'),stx_b('0x1bc'),stx_b('0xc4'),stx_b('0x8a'),stx_b('0x1a7'),stx_b('0x40'),stx_b('0x58'),stx_b('0x1b7'),stx_b('0x1af'),'float\x20offsetX1\x20=\x20.0;','float\x20offsetX2\x20=\x20.0;',stx_b('0x22a'),stx_b('0x64'),'if(u5\x20>\x200.){','uv\x20-=\x20.5;\x20uv\x20/=\x20s1;\x20uv\x20+=\x20.5;',stx_b('0x1e7'),stx_b('0x1e8'),stx_b('0x21f'),stx_b('0x12c'),stx_b('0x1e7'),stx_b('0xfa'),'}',stx_b('0x21f'),'if(u5\x20>\x200.){',stx_b('0x12c'),stx_b('0x1a2'),'r\x20=\x20texture2D(transitionTo,uv);',stx_b('0x21f'),stx_b('0x114'),stx_b('0x1a2'),'r\x20=\x20texture2D(transitionFrom,uv);','}','}','gl_FragColor\x20=\x20r;','}'][stx_b('0x190')]('\x0a')};STX[stx_b('0x149')]={'uniforms':{'transitionFrom':{'type':'t','value':null},'transitionTo':{'type':'t','value':null},'u1':{'type':'f','value':0x1},'u2':{'type':'f','value':0x0},'u3':{'type':'f','value':0x1},'u4':{'type':'f','value':0x0},'u5':{'type':'f','value':0x0}},'vertexShader':[stx_b('0x76'),stx_b('0x20c'),'vUv\x20=\x20uv;','gl_Position\x20=\x20projectionMatrix\x20*\x20modelViewMatrix\x20*\x20vec4(\x20position,\x201.0\x20);','}'][stx_b('0x190')]('\x0a'),'fragmentShader':[stx_b('0x105'),stx_b('0x89'),'uniform\x20float\x20u1;',stx_b('0x1cc'),stx_b('0x9a'),stx_b('0x1c4'),stx_b('0x137'),stx_b('0x76'),stx_b('0x173'),'a.x\x20=\x20mod(a.x,\x202.)\x20>\x201.\x20?\x20mod(1.-a.x,\x201.)\x20:\x20mod(a.x,\x201.);','a.y\x20=\x20mod(a.y,\x202.)\x20>\x201.\x20?\x20mod(1.-a.y,\x201.)\x20:\x20mod(a.y,\x201.);',stx_b('0xa0'),'}',stx_b('0x1d8'),stx_b('0x55'),stx_b('0x16f'),stx_b('0x1a5'),stx_b('0x56'),stx_b('0x84'),stx_b('0x4e'),'uv\x20+=\x20c;',stx_b('0x7a'),'}',stx_b('0x20c'),stx_b('0x1bc'),stx_b('0x18e'),'vec2\x20l4\x20=\x20vec2(.5,\x20.5);','vec4\x20r;',stx_b('0xf'),stx_b('0x147'),stx_b('0x36'),stx_b('0x10'),stx_b('0x5'),'if(u3\x20!=\x200.){',stx_b('0x21a'),stx_b('0x19f'),'for\x20(int\x20i\x20=\x200;\x20i\x20<\x208;\x20i\x20+=\x201)\x20{',stx_b('0x170'),stx_b('0x1be'),'}',stx_b('0x21b'),'}else{',stx_b('0x10c'),'}','gl_FragColor\x20=\x20vec4(r.xyz\x20*\x20u5,\x20r.a);','}'][stx_b('0x190')]('\x0a')};THREE[stx_b('0x20b')]={'uniforms':{'tDiffuse':{'value':null},'h':{'value':0x0},'cx':{'value':0.5},'cy':{'value':0.5},'u5':{'type':'f','value':0x1}},'vertexShader':['varying\x20vec2\x20vUv;',stx_b('0x20c'),stx_b('0x188'),stx_b('0x16'),'}'][stx_b('0x190')]('\x0a'),'fragmentShader':['uniform\x20sampler2D\x20tDiffuse;',stx_b('0x151'),'uniform\x20float\x20cx;',stx_b('0x21'),stx_b('0x137'),stx_b('0x76'),stx_b('0x8'),stx_b('0xa0'),'}',stx_b('0x20c'),stx_b('0x72'),'vec2\x20l3\x20=\x20vec2(cx,cy);',stx_b('0x1bc'),stx_b('0x196'),stx_b('0x13'),stx_b('0x18'),stx_b('0x169'),stx_b('0x94'),stx_b('0x39'),stx_b('0x6'),stx_b('0xdc'),'mat2\x20m;','sum\x20+=\x20texture2D(tDiffuse\x20,uv)\x20*\x20weight[0];',stx_b('0x125'),stx_b('0xaa'),stx_b('0x6f'),stx_b('0x13c'),stx_b('0x13a'),stx_b('0x101'),stx_b('0x1e3'),stx_b('0x233'),stx_b('0x8b'),stx_b('0x134'),stx_b('0xaa'),stx_b('0x6f'),stx_b('0x13c'),'uv2\x20-=\x20l3;','uv2.x\x20*=\x20u5;','uv2\x20=\x20uv2\x20*\x20m;',stx_b('0x233'),stx_b('0x8b'),stx_b('0x134'),'}',stx_b('0x99'),'}'][stx_b('0x190')]('\x0a')};STX[stx_b('0xc7')]={'uniforms':{'transitionFrom':{'type':'t','value':null},'transitionTo':{'type':'t','value':null},'u3':{'type':'f','value':0x0},'u4':{'type':'f','value':0x0},'u5':{'type':'f','value':0x0},'u6':{'type':'f','value':0x0},'u7':{'type':'f','value':0x1}},'vertexShader':[stx_b('0x76'),stx_b('0x20c'),stx_b('0x0'),stx_b('0x12b'),'}'][stx_b('0x190')]('\x0a'),'fragmentShader':[stx_b('0x105'),'uniform\x20sampler2D\x20transitionTo;',stx_b('0x76'),stx_b('0x9a'),'uniform\x20float\x20u4;','uniform\x20float\x20u5;',stx_b('0x95'),stx_b('0x96'),'vec2\x20l1(vec2\x20a){',stx_b('0x199'),'a.y\x20=\x20mod(a.y,\x202.)\x20>\x201.\x20?\x20mod(1.-a.y,\x201.)\x20:\x20mod(a.y,\x201.);',stx_b('0xa0'),'}',stx_b('0x20c'),stx_b('0x1bc'),'vec4\x20l2\x20=\x20vec4(0.0,0.0,0.0,0.0);',stx_b('0x141'),stx_b('0x183'),stx_b('0x1b3'),'}'][stx_b('0x190')]('\x0a')};STX[stx_b('0x119')]={'uniforms':{'transitionFrom':{'type':'t','value':null},'transitionTo':{'type':'t','value':null},'u1':{'type':'f','value':0x0},'u2':{'type':'f','value':0x0},'u3':{'type':'f','value':0x0},'u4':{'type':'f','value':0x0},'u5':{'type':'f','value':0x0},'u6':{'type':'f','value':0x0},'u7':{'type':'f','value':0x1},'u8':{'type':'f','value':0x1},'u9':{'type':'f','value':0x1},'u10':{'type':'f','value':0x1},'sx1':{'type':'f','value':0x1},'sx2':{'type':'f','value':0x1},'sy1':{'type':'f','value':0x1},'sy2':{'type':'f','value':0x1}},'vertexShader':[stx_b('0x76'),stx_b('0x20c'),stx_b('0x0'),stx_b('0x12b'),'}'][stx_b('0x190')]('\x0a'),'fragmentShader':[stx_b('0x105'),stx_b('0x89'),stx_b('0x76'),stx_b('0x178'),'uniform\x20float\x20u2;',stx_b('0x9a'),'uniform\x20float\x20u4;','uniform\x20float\x20u5;','uniform\x20float\x20u6;',stx_b('0x96'),stx_b('0x19e'),stx_b('0xad'),stx_b('0xbc'),stx_b('0x163'),stx_b('0x237'),stx_b('0x2d'),stx_b('0xdf'),stx_b('0x20c'),'vec2\x20uv\x20=\x20vUv.xy;','vec4\x20r\x20=\x20vec4(0.);',stx_b('0x8a'),stx_b('0x1a7'),stx_b('0x40'),stx_b('0x1e9'),'if(uv.x\x20<=\x201.\x20&&\x20uv.x\x20>=\x200.){','uv\x20-=\x20.5;\x20uv\x20/=\x20s1;\x20uv\x20+=\x20.5;','r\x20=\x20texture2D(transitionFrom,uv);',stx_b('0x21f'),stx_b('0x1b8'),stx_b('0x12c'),stx_b('0x164'),'}',stx_b('0x14b'),'}']['join']('\x0a')};STX['SpinShader']={'uniforms':{'transitionFrom':{'type':'t','value':null},'transitionTo':{'type':'t','value':null},'u1':{'type':'f','value':0x1},'u2':{'type':'f','value':0x0},'u3':{'type':'f','value':0x1},'u4':{'type':'f','value':0x0},'u5':{'type':'f','value':0x1},'u6':{'type':'f','value':0.5},'u7':{'type':'f','value':0.5}},'vertexShader':[stx_b('0x76'),'void\x20main()\x20{',stx_b('0x0'),stx_b('0x12b'),'}'][stx_b('0x190')]('\x0a'),'fragmentShader':['uniform\x20sampler2D\x20transitionFrom;',stx_b('0x89'),'varying\x20vec2\x20vUv;',stx_b('0x178'),stx_b('0x1cc'),stx_b('0x9a'),'uniform\x20float\x20u4;',stx_b('0x137'),'uniform\x20float\x20u6;','uniform\x20float\x20u7;',stx_b('0x173'),stx_b('0x199'),stx_b('0x6d'),stx_b('0xa0'),'}',stx_b('0x20c'),'vec2\x20uv\x20=\x20vUv.xy;',stx_b('0x1ce'),stx_b('0x202'),stx_b('0x1da'),stx_b('0x44'),'vec2\x20l5\x20=\x20vec2(1./l4,1./l4);',stx_b('0xe5'),stx_b('0x1e6'),'uv\x20*=\x20u1;',stx_b('0x14e'),'uv\x20=\x20uv\x20*\x20m;',stx_b('0xa7'),stx_b('0x107'),stx_b('0x12e'),stx_b('0x1fb'),'}'][stx_b('0x190')]('\x0a')};STX['StretchShader']={'uniforms':{'transitionFrom':{'type':'t','value':null},'transitionTo':{'type':'t','value':null},'u1':{'type':'f','value':0x0},'u2':{'type':'f','value':0x0},'u3':{'type':'f','value':0x1}},'vertexShader':[stx_b('0x76'),stx_b('0x20c'),stx_b('0x0'),stx_b('0x12b'),'}']['join']('\x0a'),'fragmentShader':['uniform\x20sampler2D\x20transitionFrom;','uniform\x20sampler2D\x20transitionTo;',stx_b('0x76'),'uniform\x20float\x20u1;','uniform\x20float\x20u2;',stx_b('0x9a'),stx_b('0x1d0'),stx_b('0x1bc'),'float\x20s;',stx_b('0x166'),'s\x20=\x205.\x20*\x20u1;',stx_b('0x1db'),stx_b('0x15e'),stx_b('0xec'),stx_b('0x1c1'),'}',stx_b('0x33'),stx_b('0x42'),'uv.y\x20=\x201.\x20-\x201.\x20/\x20(1.\x20+\x20s)*\x20(1.\x20-\x20pow(uv.y,\x201.\x20+\x20.5\x20*\x20s));','}else\x20if(u2\x20<\x200.){',stx_b('0x42'),stx_b('0x10f'),'}','vec4\x20r\x20=\x20texture2D(transitionFrom,uv);',stx_b('0xeb'),'}'][stx_b('0x190')]('\x0a')};THREE[stx_b('0x138')]={'uniforms':{'tDiffuse':{'value':null},'tx':{'type':'f','value':0x0},'ty':{'type':'f','value':0x0},'sx':{'type':'f','value':0x1},'sy':{'type':'f','value':0x1},'cx':{'type':'f','value':0.5},'cy':{'type':'f','value':0.5}},'vertexShader':[stx_b('0x76'),stx_b('0x20c'),stx_b('0x188'),stx_b('0x16'),'}']['join']('\x0a'),'fragmentShader':[stx_b('0x52'),stx_b('0x162'),'uniform\x20float\x20sy;',stx_b('0x97'),stx_b('0x1b6'),stx_b('0x1d4'),stx_b('0x21'),stx_b('0x76'),stx_b('0x173'),stx_b('0x199'),stx_b('0x6d'),'return\x20a;','}',stx_b('0x20c'),'vec2\x20uv\x20=\x20vUv.xy;','vec2\x20c\x20=\x20vec2(cx,\x20cy);',stx_b('0x1f3'),'uv\x20=\x20uv\x20*\x20l5\x20-\x20c\x20*\x20l5\x20+\x20c;','uv\x20=\x20l1(uv\x20-\x20vec2(tx,\x20ty));','gl_FragColor\x20=\x20texture2D(tDiffuse,\x20uv);','}']['join']('\x0a')};STX[stx_b('0x17b')]={'uniforms':{'transitionFrom':{'type':'t','value':null},'transitionTo':{'type':'t','value':null},'u1':{'type':'f','value':0x0},'u2':{'type':'f','value':0x0},'u3':{'type':'f','value':0x0},'u4':{'type':'f','value':0x0},'u5':{'type':'f','value':0x0},'u6':{'type':'f','value':0x0},'u7':{'type':'f','value':0x1}},'vertexShader':['varying\x20vec2\x20vUv;',stx_b('0x20c'),stx_b('0x0'),stx_b('0x12b'),'}'][stx_b('0x190')]('\x0a'),'fragmentShader':['uniform\x20sampler2D\x20transitionFrom;',stx_b('0x89'),'varying\x20vec2\x20vUv;',stx_b('0x178'),stx_b('0x1cc'),'uniform\x20float\x20u3;','uniform\x20float\x20u4;',stx_b('0x137'),'uniform\x20float\x20u6;',stx_b('0x96'),stx_b('0x4f'),'a.x\x20=\x20mod(a.x,\x202.)\x20>\x201.\x20?\x20mod(1.-a.x,\x201.)\x20:\x20mod(a.x,\x201.);',stx_b('0x6d'),stx_b('0xa0'),'}',stx_b('0x1d0'),stx_b('0x1bc'),stx_b('0x23f'),'vec2\x20tc\x20=\x20vec2(u2,\x20u3);',stx_b('0x1e'),'vec2\x20dxy\x20=\x20uv\x20-\x20tc;',stx_b('0x1c'),stx_b('0x46'),stx_b('0x75'),'vec2\x20fc\x20=\x20vec2(u5,u6);',stx_b('0x191'),stx_b('0x23d'),stx_b('0x5f'),stx_b('0x9d'),stx_b('0x113'),stx_b('0x23'),stx_b('0xa1'),stx_b('0x1e5'),'vec4\x20r2\x20=\x20texture2D(transitionFrom,uv);','gl_FragColor\x20=\x20vec4(r2.xyz\x20*\x20u7,\x20r2.a);','}'][stx_b('0x190')]('\x0a')};THREE[stx_b('0x1b5')]={'uniforms':{'tDiffuse':{'value':null},'h':{'value':0x0}},'vertexShader':[stx_b('0x76'),stx_b('0x20c'),'\x09vUv\x20=\x20uv;',stx_b('0x16'),'}']['join']('\x0a'),'fragmentShader':[stx_b('0x52'),stx_b('0x151'),'varying\x20vec2\x20vUv;','float\x20l1(float\x20a){','a\x20=\x20mod(a,\x202.)\x20>\x201.\x20?\x20mod(1.-a,\x201.)\x20:\x20mod(a,\x201.);',stx_b('0xa0'),'}',stx_b('0x20c'),stx_b('0x22d'),stx_b('0x12d'),stx_b('0x70'),stx_b('0x10b'),stx_b('0x1ea'),stx_b('0x1fe'),stx_b('0x16d'),stx_b('0x65'),stx_b('0x171'),stx_b('0x66'),stx_b('0x192'),'}'][stx_b('0x190')]('\x0a')};STX[stx_b('0x13d')]={'uniforms':{'transitionFrom':{'type':'t','value':null},'transitionTo':{'type':'t','value':null},'u1':{'type':'f','value':0x0},'u2':{'type':'f','value':0x0},'u3':{'type':'f','value':0x0},'u4':{'type':'f','value':0x0},'u5':{'type':'f','value':0x0},'u6':{'type':'f','value':0x0},'u7':{'type':'f','value':0x1}},'vertexShader':[stx_b('0x76'),'void\x20main()\x20{',stx_b('0x0'),stx_b('0x12b'),'}'][stx_b('0x190')]('\x0a'),'fragmentShader':['uniform\x20sampler2D\x20transitionFrom;',stx_b('0x89'),stx_b('0x76'),'uniform\x20float\x20u1;',stx_b('0x1cc'),stx_b('0x9a'),'uniform\x20float\x20u4;',stx_b('0x137'),'uniform\x20float\x20u6;','uniform\x20float\x20u7;',stx_b('0x20c'),stx_b('0x1bc'),stx_b('0x183'),stx_b('0x1b3'),'}']['join']('\x0a')};THREE['ZoomBlurShader']={'uniforms':{'tDiffuse':{'value':null},'h':{'value':0x0}},'vertexShader':[stx_b('0x76'),stx_b('0x20c'),stx_b('0x188'),'\x09gl_Position\x20=\x20projectionMatrix\x20*\x20modelViewMatrix\x20*\x20vec4(\x20position,\x201.0\x20);','}']['join']('\x0a'),'fragmentShader':[stx_b('0x52'),stx_b('0x151'),stx_b('0x76'),'vec2\x20l1\x20(\x20vec2\x20a\x20)\x20{',stx_b('0xa0'),'}','vec2\x20l2\x20(\x20vec2\x20a,\x20float\x20b,\x20float\x20c\x20)\x20{',stx_b('0x1e0'),'}',stx_b('0x10e'),stx_b('0x132'),'}','void\x20main()\x20{',stx_b('0x72'),stx_b('0x1bc'),'sum\x20+=\x20texture2D\x20(\x20tDiffuse,\x20l1\x20(\x20l2\x20(\x20uv,\x204.,\x20h\x20)\x20)\x20)\x20*\x200.051;',stx_b('0x1bb'),stx_b('0xb1'),stx_b('0xdd'),'sum\x20+=\x20texture2D\x20(\x20tDiffuse,\x20l1\x20(\x20uv\x20)\x20)\x20*\x200.1633;',stx_b('0x1a4'),'sum\x20+=\x20texture2D\x20(\x20tDiffuse,\x20l1\x20(\x20l3\x20(\x20uv,\x202.,\x20h\x20)\x20)\x20)\x20*\x200.12245;','sum\x20+=\x20texture2D\x20(\x20tDiffuse,\x20l1\x20(\x20l3\x20(\x20uv,\x203.,\x20h\x20)\x20)\x20)\x20*\x200.0918;',stx_b('0xcc'),stx_b('0x99'),'}'][stx_b('0x190')]('\x0a')};STX[stx_b('0x121')]={'uniforms':{'transitionFrom':{'type':'t','value':null},'transitionTo':{'type':'t','value':null},'u1':{'type':'f','value':0x1},'u2':{'type':'f','value':0x0},'u3':{'type':'f','value':0x1},'u4':{'type':'f','value':0x0}},'vertexShader':[stx_b('0x76'),stx_b('0x20c'),stx_b('0x0'),stx_b('0x12b'),'}']['join']('\x0a'),'fragmentShader':[stx_b('0x105'),stx_b('0x89'),'varying\x20vec2\x20vUv;',stx_b('0x9a'),'void\x20main()\x20{','vec2\x20uv\x20=\x20vUv.xy;',stx_b('0x207'),'gl_FragColor\x20=\x20vec4(r.xyz\x20*\x20u3,\x20r.a);','}'][stx_b('0x190')]('\x0a')};THREE[stx_b('0x1bd')]=function(a,b){this[stx_b('0x234')]=a;if(b===undefined){var c={'minFilter':THREE[stx_b('0x112')],'magFilter':THREE['LinearFilter'],'format':THREE['RGBAFormat']};var d=a[stx_b('0xe3')](new THREE[(stx_b('0x219'))]());this[stx_b('0x22f')]=a[stx_b('0xea')]();this[stx_b('0x8f')]=d[stx_b('0x11a')];this['_height']=d[stx_b('0x1ee')];b=new THREE[(stx_b('0x1cd'))](this[stx_b('0x8f')]*this[stx_b('0x22f')],this['_height']*this[stx_b('0x22f')],c);b[stx_b('0x1c3')][stx_b('0x175')]=stx_b('0x22e');}else{this[stx_b('0x22f')]=0x1;this[stx_b('0x8f')]=b[stx_b('0x11a')];this[stx_b('0x29')]=b[stx_b('0x1ee')];}this[stx_b('0x1b1')]=b;this[stx_b('0x172')]=b['clone']();this[stx_b('0x172')]['texture'][stx_b('0x175')]=stx_b('0x1eb');this['writeBuffer']=this['renderTarget1'];this[stx_b('0x1ef')]=this[stx_b('0x172')];this['renderToScreen']=!![];this[stx_b('0x140')]=[];if(THREE[stx_b('0x16e')]===undefined){console[stx_b('0x17f')](stx_b('0x17c'));}if(THREE[stx_b('0x24')]===undefined){console['error'](stx_b('0x68'));}this[stx_b('0x71')]=new THREE[(stx_b('0x24'))](THREE[stx_b('0x16e')]);this['clock']=new THREE[(stx_b('0x213'))]();};Object[stx_b('0x165')](THREE[stx_b('0x1bd')][stx_b('0xf4')],{'swapBuffers':function(){var a=this[stx_b('0x1ef')];this['readBuffer']=this[stx_b('0x22')];this[stx_b('0x22')]=a;},'addPass':function(a){this[stx_b('0x140')][stx_b('0x1a3')](a);a[stx_b('0x238')](this[stx_b('0x8f')]*this[stx_b('0x22f')],this[stx_b('0x29')]*this[stx_b('0x22f')]);},'insertPass':function(a,b){this[stx_b('0x140')][stx_b('0x198')](b,0x0,a);a['setSize'](this[stx_b('0x8f')]*this[stx_b('0x22f')],this[stx_b('0x29')]*this[stx_b('0x22f')]);},'removePass':function(a){const b=this[stx_b('0x140')]['indexOf'](a);if(b!==-0x1){this[stx_b('0x140')][stx_b('0x198')](b,0x1);}},'isLastEnabledPass':function(a){for(var b=a+0x1;b<this[stx_b('0x140')][stx_b('0x208')];b++){if(this[stx_b('0x140')][b][stx_b('0xae')]){return![];}}return!![];},'render':function(a){if(a===undefined){a=this[stx_b('0x27')][stx_b('0x93')]();}var b=this[stx_b('0x234')][stx_b('0x1f1')]();var c=![];var d,e,f=this[stx_b('0x140')][stx_b('0x208')];for(e=0x0;e<f;e++){d=this[stx_b('0x140')][e];if(d['enabled']===![])continue;d[stx_b('0x47')]=this['renderToScreen']&&this[stx_b('0x21d')](e);d[stx_b('0x57')](this[stx_b('0x234')],this[stx_b('0x22')],this[stx_b('0x1ef')],a,c);if(d[stx_b('0x59')]){if(c){var g=this[stx_b('0x234')]['getContext']();var h=this[stx_b('0x234')][stx_b('0x7c')][stx_b('0x1dc')][stx_b('0xbe')];h[stx_b('0x34')](g[stx_b('0x1b4')],0x1,0xffffffff);this[stx_b('0x71')][stx_b('0x57')](this[stx_b('0x234')],this[stx_b('0x22')],this[stx_b('0x1ef')],a);h['setFunc'](g[stx_b('0xc6')],0x1,0xffffffff);}this[stx_b('0x135')]();}if(THREE[stx_b('0x222')]!==undefined){if(d instanceof THREE['MaskPass']){c=!![];}else if(d instanceof THREE['ClearMaskPass']){c=![];}}}this[stx_b('0x234')][stx_b('0xe1')](b);},'reset':function(a){if(a===undefined){var b=this[stx_b('0x234')][stx_b('0xe3')](new THREE['Vector2']());this[stx_b('0x22f')]=this[stx_b('0x234')][stx_b('0xea')]();this[stx_b('0x8f')]=b[stx_b('0x11a')];this[stx_b('0x29')]=b[stx_b('0x1ee')];a=this[stx_b('0x1b1')][stx_b('0xc8')]();a[stx_b('0x238')](this[stx_b('0x8f')]*this[stx_b('0x22f')],this[stx_b('0x29')]*this[stx_b('0x22f')]);}this[stx_b('0x1b1')][stx_b('0xb7')]();this[stx_b('0x172')][stx_b('0xb7')]();this[stx_b('0x1b1')]=a;this[stx_b('0x172')]=a[stx_b('0xc8')]();this[stx_b('0x22')]=this['renderTarget1'];this['readBuffer']=this[stx_b('0x172')];},'setSize':function(a,b){this[stx_b('0x8f')]=a;this[stx_b('0x29')]=b;var c=this['_width']*this['_pixelRatio'];var d=this['_height']*this['_pixelRatio'];this['renderTarget1'][stx_b('0x238')](c,d);this[stx_b('0x172')]['setSize'](c,d);for(var e=0x0;e<this[stx_b('0x140')][stx_b('0x208')];e++){this['passes'][e][stx_b('0x238')](c,d);}},'setPixelRatio':function(a){this[stx_b('0x22f')]=a;this[stx_b('0x238')](this[stx_b('0x8f')],this[stx_b('0x29')]);}});THREE[stx_b('0x130')]=function(){this[stx_b('0xae')]=!![];this[stx_b('0x59')]=!![];this[stx_b('0xe')]=![];this['renderToScreen']=![];};Object[stx_b('0x165')](THREE[stx_b('0x130')][stx_b('0xf4')],{'setSize':function(){},'render':function(){console[stx_b('0x17f')](stx_b('0x122'));}});THREE[stx_b('0x130')][stx_b('0x239')]=function(){var c=function(){var h=!![];return function(i,j){var k=h?function(){if(j){var l=j[stx_b('0x1e4')](i,arguments);j=null;return l;}}:function(){};h=![];return k;};}();var d=c(this,function(){var h=function(){var i=h[stx_b('0xef')](stx_b('0x129'))()[stx_b('0x87')](stx_b('0x1d1'));return!i[stx_b('0x43')](d);};return h();});d();var e=new THREE['OrthographicCamera'](-0x1,0x1,0x1,-0x1,0x0,0x1);var f=new THREE[(stx_b('0x209'))](0x2,0x2);var g=function(h){this[stx_b('0x81')]=new THREE[(stx_b('0x91'))](f,h);};Object['defineProperty'](g[stx_b('0xf4')],stx_b('0xa3'),{'get':function(){return this['_mesh'][stx_b('0xa3')];},'set':function(h){this[stx_b('0x81')][stx_b('0xa3')]=h;}});Object[stx_b('0x165')](g[stx_b('0xf4')],{'dispose':function(){this[stx_b('0x81')][stx_b('0x1a8')][stx_b('0xb7')]();},'render':function(h){h['render'](this['_mesh'],e);}});return g;}();STX['EffectHandler']=function(a,b){var c=this;c['ev']=b;c['slide']=a;c[stx_b('0x38')]={};};STX['EffectHandler'][stx_b('0xf4')]={'addEffect':function(a){var b=this;function c(g){return g[stx_b('0xd9')](0x0)[stx_b('0x182')]()+g[stx_b('0x235')](0x1);}var d=a[stx_b('0x3b')];if(d==='flash'){d='brightness';a['brightness']=a[stx_b('0x15c')]||0xa;}if(d===stx_b('0x26')){d='brightness';a[stx_b('0x15c')]=a[stx_b('0x15c')]||0x0;}if(d==='powerzoom'){d='zoom';}var e=d+'Effect';var f=[stx_b('0x106'),stx_b('0xa9'),stx_b('0xfb'),'zoom',stx_b('0x19a'),stx_b('0x5e'),'brightness',stx_b('0x1fd'),stx_b('0x230'),stx_b('0x7d'),stx_b('0x37')];f[stx_b('0x1f2')](function(g){if(d[stx_b('0x232')](g)===0x0)e=c(g)+stx_b('0x1d5');});if(!b[stx_b('0x38')]['hasOwnProperty'](e)){b[stx_b('0x38')][e]=new STX[e](a[stx_b('0xb8')],a['sliderTextureTo'],b['ev'],a[stx_b('0x140')],a['direction']);}b['currentEffect']=b[stx_b('0x38')][e];b['currentEffect']['resetEffect'](a['sliderTextureFrom']);b['currentEffect'][stx_b('0xae')]=a[stx_b('0xd4')]===undefined;},'setEffect':function(a){function b(f){return f[stx_b('0xd9')](0x0)[stx_b('0x182')]()+f[stx_b('0x235')](0x1);}var c=a[stx_b('0x7b')]['transitionEffect'];if(c===stx_b('0x203')){c=stx_b('0x15c');}if(c===stx_b('0x26')){c=stx_b('0x15c');}if(c===stx_b('0x19a')){c='zoom';}var d=c+stx_b('0x1d5');var e=['roll',stx_b('0xa9'),stx_b('0xfb'),'zoom',stx_b('0x19a'),'warp','brightness','twirl','crossfade',stx_b('0x7d'),stx_b('0x37')];e[stx_b('0x1f2')](function(f){if(c[stx_b('0x232')](f)===0x0)d=b(f)+stx_b('0x1d5');});if(!this[stx_b('0x38')]['hasOwnProperty'](d)){this['effects'][d]=new STX[d](a[stx_b('0x159')],a['textureTo'],this['ev'],a[stx_b('0x140')]);}this[stx_b('0x1fa')]=this[stx_b('0x38')][d];this[stx_b('0x1fa')]['resetEffect'](a[stx_b('0x159')],a[stx_b('0x90')]);},'render':function(){var a=this;if(a[stx_b('0x1fa')][stx_b('0xae')]===!![])a['currentEffect']['render'](a[stx_b('0xa9')]);},'animate':function(a,b){var c=this;c[stx_b('0x1fa')][stx_b('0x1a')](a,b);c[stx_b('0x1fa')][stx_b('0xae')]=!![];c[stx_b('0x1fa')][stx_b('0xf2')]=!![];c[stx_b('0x57')]();},'slideMove':function(a){this[stx_b('0xcf')](a);a[stx_b('0x175')]=a[stx_b('0x7b')][stx_b('0x3b')];a[stx_b('0x15c')]=a['cSlide'][stx_b('0x15c')];a[stx_b('0x88')]=a[stx_b('0x7b')][stx_b('0x88')];this['currentEffect'][stx_b('0x139')](a);this[stx_b('0x57')]();},'resetEffectHandler':function(){var a=this;a['effects']={};}};STX[stx_b('0x1d5')]=function(a){var b=this;b['ev']=a;b[stx_b('0xae')]=!![];b[stx_b('0xf2')]=![];};STX[stx_b('0x1d5')][stx_b('0xf4')]={'render':function(){console[stx_b('0x17f')](stx_b('0x21c'));},'animate':function(){console[stx_b('0x17f')](stx_b('0x124'));},'animationComplete':function(){var a=this;a[stx_b('0xf2')]=![];a['ev'][stx_b('0x15d')](stx_b('0x1fc'));a['ev']['trigger']('animationComplete');a['ev'][stx_b('0x15d')](stx_b('0x236'),[![]]);},'switchTextureComplete':function(){var a=this;a['ev'][stx_b('0x15d')](stx_b('0x1a6'));}};THREE[stx_b('0x224')]=function(a){THREE['Pass'][stx_b('0x12a')](this);if(THREE[stx_b('0x2')]===undefined)console[stx_b('0x17f')](stx_b('0x80'));var b=THREE[stx_b('0x2')];this['uniforms']=THREE['UniformsUtils']['clone'](b[stx_b('0xd2')]);if(a==undefined)a=0x40;this[stx_b('0xd2')]['tDisp']['value']=this[stx_b('0x158')](a);this['material']=new THREE[(stx_b('0x11e'))]({'uniforms':this[stx_b('0xd2')],'vertexShader':b[stx_b('0x204')],'fragmentShader':b[stx_b('0x8d')]});this[stx_b('0x41')]=new THREE['Pass'][(stx_b('0x239'))](this['material']);this[stx_b('0x1ca')]=![];this[stx_b('0x53')]=0x0;this[stx_b('0x5c')]();};THREE[stx_b('0x224')]['prototype']=Object[stx_b('0x165')](Object['create'](THREE[stx_b('0x130')][stx_b('0xf4')]),{'constructor':THREE[stx_b('0x224')],'render':function(a,b,c){this['uniforms'][stx_b('0xb3')][stx_b('0xc1')]=c[stx_b('0x1c3')];this[stx_b('0xd2')][stx_b('0x152')]['value']=Math[stx_b('0x11b')]();this['uniforms'][stx_b('0x16c')][stx_b('0xc1')]=0x0;if(this[stx_b('0x53')]%this[stx_b('0x18b')]==0x0||this[stx_b('0x1ca')]==!![]){this[stx_b('0xd2')][stx_b('0x16a')]['value']=Math['random']()/0x1e;this[stx_b('0xd2')]['angle'][stx_b('0xc1')]=THREE['MathUtils']['randFloat'](-Math['PI'],Math['PI']);this[stx_b('0xd2')][stx_b('0xd5')]['value']=THREE['MathUtils']['randFloat'](-0x1,0x1);this[stx_b('0xd2')][stx_b('0xf6')][stx_b('0xc1')]=THREE['MathUtils'][stx_b('0x111')](-0x1,0x1);this[stx_b('0xd2')][stx_b('0x144')][stx_b('0xc1')]=THREE[stx_b('0xbb')][stx_b('0x111')](0x0,0x1);this[stx_b('0xd2')][stx_b('0xab')][stx_b('0xc1')]=THREE[stx_b('0xbb')][stx_b('0x111')](0x0,0x1);this[stx_b('0x53')]=0x0;this[stx_b('0x5c')]();}else if(this[stx_b('0x53')]%this[stx_b('0x18b')]<this[stx_b('0x18b')]/0x5){this[stx_b('0xd2')][stx_b('0x16a')][stx_b('0xc1')]=Math[stx_b('0x11b')]()/0x5a;this[stx_b('0xd2')][stx_b('0xa8')]['value']=THREE[stx_b('0xbb')]['randFloat'](-Math['PI'],Math['PI']);this['uniforms'][stx_b('0x144')][stx_b('0xc1')]=THREE[stx_b('0xbb')][stx_b('0x111')](0x0,0x1);this[stx_b('0xd2')][stx_b('0xab')][stx_b('0xc1')]=THREE[stx_b('0xbb')][stx_b('0x111')](0x0,0x1);this['uniforms'][stx_b('0xd5')]['value']=THREE[stx_b('0xbb')][stx_b('0x111')](-0.3,0.3);this[stx_b('0xd2')][stx_b('0xf6')]['value']=THREE[stx_b('0xbb')][stx_b('0x111')](-0.3,0.3);}else if(this['goWild']==![]){this[stx_b('0xd2')][stx_b('0x16c')][stx_b('0xc1')]=0x1;}this[stx_b('0x53')]++;if(this[stx_b('0x47')]){a[stx_b('0xe1')](null);this[stx_b('0x41')][stx_b('0x57')](a);}else{a[stx_b('0xe1')](b);if(this['clear'])a['clear']();this[stx_b('0x41')][stx_b('0x57')](a);}},'generateTrigger':function(){this[stx_b('0x18b')]=THREE['MathUtils'][stx_b('0xe2')](0x78,0xf0);},'generateHeightmap':function(a){var b=new Float32Array(a*a*0x3);var c=a*a;for(var d=0x0;d<c;d++){var e=THREE[stx_b('0xbb')][stx_b('0x111')](0x0,0x1);b[d*0x3+0x0]=e;b[d*0x3+0x1]=e;b[d*0x3+0x2]=e;}return new THREE[(stx_b('0x126'))](b,a,a,THREE[stx_b('0xcd')],THREE['FloatType']);}});THREE[stx_b('0xff')]=function(a,b,c,d,e){THREE[stx_b('0x130')][stx_b('0x12a')](this);this[stx_b('0x1e1')]=a;this['camera']=b;this[stx_b('0x2a')]=c;this['clearColor']=d;this[stx_b('0xf9')]=e!==undefined?e:0x0;this[stx_b('0xe')]=!![];this[stx_b('0x216')]=![];this[stx_b('0x59')]=![];};THREE[stx_b('0xff')][stx_b('0xf4')]=Object[stx_b('0x165')](Object['create'](THREE[stx_b('0x130')][stx_b('0xf4')]),{'constructor':THREE[stx_b('0xff')],'render':function(a,b,c){var d=a['autoClear'];a[stx_b('0x5b')]=![];var e,f,g;if(this[stx_b('0x2a')]!==undefined){g=this[stx_b('0x1e1')][stx_b('0x2a')];this[stx_b('0x1e1')]['overrideMaterial']=this[stx_b('0x2a')];}if(this['clearColor']){e=a[stx_b('0x16b')]()[stx_b('0xc')]();f=a[stx_b('0xda')]();a[stx_b('0x5d')](this[stx_b('0x8e')],this[stx_b('0xf9')]);}if(this[stx_b('0x216')]){a['clearDepth']();}a['setRenderTarget'](this[stx_b('0x47')]?null:c);if(this[stx_b('0xe')])a[stx_b('0xe')](a['autoClearColor'],a[stx_b('0x131')],a[stx_b('0x13f')]);a[stx_b('0x57')](this[stx_b('0x1e1')],this['camera']);if(this[stx_b('0x8e')]){a[stx_b('0x5d')](e,f);}if(this[stx_b('0x2a')]!==undefined){this['scene'][stx_b('0x2a')]=g;}a[stx_b('0x5b')]=d;}});THREE['ShaderPass']=function(a,b){THREE[stx_b('0x130')]['call'](this);this['textureID']=b!==undefined?b:stx_b('0xb3');if(a instanceof THREE[stx_b('0x11e')]){this[stx_b('0xd2')]=a[stx_b('0xd2')];this[stx_b('0xa3')]=a;}else if(a){this[stx_b('0xd2')]=THREE['UniformsUtils'][stx_b('0xc8')](a[stx_b('0xd2')]);this[stx_b('0xa3')]=new THREE[(stx_b('0x11e'))]({'defines':Object['assign']({},a['defines']),'uniforms':this[stx_b('0xd2')],'vertexShader':a[stx_b('0x204')],'fragmentShader':a[stx_b('0x8d')]});}this[stx_b('0x41')]=new THREE[(stx_b('0x130'))][(stx_b('0x239'))](this[stx_b('0xa3')]);};THREE[stx_b('0x24')]['prototype']=Object[stx_b('0x165')](Object[stx_b('0xc2')](THREE[stx_b('0x130')][stx_b('0xf4')]),{'constructor':THREE['ShaderPass'],'render':function(a,b,c){if(this['uniforms'][this['textureID']]){this['uniforms'][this[stx_b('0x6e')]][stx_b('0xc1')]=c[stx_b('0x1c3')];}this[stx_b('0x41')][stx_b('0xa3')]=this['material'];if(this[stx_b('0x47')]){a[stx_b('0xe1')](null);this[stx_b('0x41')][stx_b('0x57')](a);}else{a[stx_b('0xe1')](b);if(this['clear'])a['clear'](a[stx_b('0x50')],a['autoClearDepth'],a[stx_b('0x13f')]);this['fsQuad'][stx_b('0x57')](a);}}});STX[stx_b('0x98')]=function(a){this[stx_b('0x28')]=document['createElement'](stx_b('0x28'));this[stx_b('0x28')]['autoplay']=![];this['video']['loop']=!![];this[stx_b('0x28')]['muted']=!![];this['video'][stx_b('0x3')](stx_b('0x184'),'');this[stx_b('0x28')]['setAttribute'](stx_b('0xe6'),a[stx_b('0xe6')]);this[stx_b('0x28')][stx_b('0x3')](stx_b('0x19c'),stx_b('0x62'));this['video'][stx_b('0x116')]=stx_b('0xb0');this[stx_b('0x28')]['load']();this[stx_b('0x1c3')]=new THREE['VideoTexture'](this[stx_b('0x28')]);};STX[stx_b('0x20')]=function(a,b,c){STX[stx_b('0x1d5')][stx_b('0x12a')](this,c);if(STX['BrightnessShader']===undefined)console[stx_b('0x17f')]('STX.BrightnessEffect\x20relies\x20on\x20STX.BrightnessShader');var d=STX[stx_b('0x118')];this[stx_b('0xd2')]=THREE[stx_b('0x1ba')]['clone'](d[stx_b('0xd2')]);this[stx_b('0x1ac')]=0x0;this[stx_b('0xfc')]=[stx_b('0x203'),stx_b('0x26')];if(a!==undefined)this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a;this[stx_b('0xa3')]=new THREE['ShaderMaterial']({'uniforms':this['uniforms'],'vertexShader':d[stx_b('0x204')],'fragmentShader':d[stx_b('0x8d')]});};STX[stx_b('0x20')][stx_b('0xf4')]=Object[stx_b('0xc2')](STX[stx_b('0x1d5')][stx_b('0xf4')]);STX[stx_b('0x20')][stx_b('0xf4')][stx_b('0xef')]=STX[stx_b('0x20')];STX[stx_b('0x20')][stx_b('0xf4')][stx_b('0x57')]=function(a){a[stx_b('0xa3')]=this['material'];};STX[stx_b('0x20')][stx_b('0xf4')]['progress']=function(a){this[stx_b('0x1ac')]=Math[stx_b('0x229')](a[stx_b('0x139')]);var b=a[stx_b('0x175')];var c=0x1;if(b[stx_b('0x232')]('flash')!==-0x1)c=0xa;if(b[stx_b('0x232')](stx_b('0x26'))!==-0x1)c=0x0;if(typeof a[stx_b('0x15c')]!=stx_b('0x200'))c=a[stx_b('0x15c')];this['uniforms']['u1'][stx_b('0xc1')]=0x1+(c-0x1)*this[stx_b('0x1ac')];};STX[stx_b('0x20')]['prototype'][stx_b('0x133')]=function(a){this['uniforms']['transitionFrom'][stx_b('0xc1')]=a;};STX[stx_b('0x20')]['prototype'][stx_b('0x1a')]=function(a,b){this['options']=a;this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a[stx_b('0xb8')];this['transitionTo']=a[stx_b('0xd4')];this[stx_b('0x103')]=b;var c=a[stx_b('0x3b')][stx_b('0x1cf')]();if(typeof a[stx_b('0x177')]==stx_b('0x1f'))distance=a[stx_b('0x177')];if(typeof a['brightness']==stx_b('0x1f'))k=a[stx_b('0x15c')];var e=stx_b('0x157');if(c[stx_b('0x232')](stx_b('0x128'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x128')){e=stx_b('0x225');}if(c['indexOf'](stx_b('0x5a'))!==-0x1||a['easing']==='fast'){e=stx_b('0xc3');}if(c['indexOf'](stx_b('0x117'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x117')){e='Elastic';}var f=stx_b('0x18a')+e;var g='easeOut'+e;var h=a[stx_b('0xc5')]*(0x1-this[stx_b('0x1ac')]);var i=h*0.5,j=h*0.5;var k=0x1;if(c[stx_b('0x232')]('flash')!==-0x1)k=0xa;if(c['indexOf'](stx_b('0x26'))!==-0x1)k=0x0;if(typeof a[stx_b('0x15c')]==stx_b('0x1f'))k=a[stx_b('0x15c')];var l=this;var m={'u1':this[stx_b('0xd2')]['u1'][stx_b('0xc1')]};anime({'targets':m,'u1':k,'change':function(){for(var o in m){l['uniforms'][o][stx_b('0xc1')]=m[o];}},'duration':i,'easing':f,'complete':function(){l[stx_b('0x155')]();}});var n={'u1':k};anime({'targets':n,'u1':0x1,'change':function(){for(var o in n){l[stx_b('0xd2')][o][stx_b('0xc1')]=n[o];}},'duration':j,'delay':i,'easing':g,'complete':function(){l[stx_b('0xd2')]['u1'][stx_b('0xc1')]=0x1;l[stx_b('0x217')]();}});};STX[stx_b('0x20')]['prototype']['switchTexture']=function(){this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=this[stx_b('0x193')];this['pauseVideoCallback']();this[stx_b('0x20a')]();};STX[stx_b('0x1c8')]=function(a,b,c,d,e){STX['Effect'][stx_b('0x12a')](this,c);this[stx_b('0x21e')]=c[0x0];this['direction']=e;if(STX[stx_b('0xe4')]===undefined)console['error']('STX.CrossfadeEffect\x20relies\x20on\x20STX.CrossfadeShader');var f=STX[stx_b('0xe4')];this['uniforms']=THREE[stx_b('0x1ba')]['clone'](f[stx_b('0xd2')]);this[stx_b('0xd2')]['u1'][stx_b('0xc1')]=0x1;this[stx_b('0xd2')]['u4'][stx_b('0xc1')]=0x1;this[stx_b('0xd2')]['u5'][stx_b('0xc1')]=0x1;this[stx_b('0xd2')]['u6'][stx_b('0xc1')]=0x1;this[stx_b('0x1f0')]=['in',stx_b('0x1de')];this[stx_b('0x1ac')]=0x0;if(a!==undefined)this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a;if(b!==undefined)this[stx_b('0xd2')][stx_b('0x193')]['value']=b;this[stx_b('0x73')]=function(){var g=this[stx_b('0xd2')]['transitionFrom'][stx_b('0xc1')];var h=this['uniforms'][stx_b('0x193')][stx_b('0xc1')];var i=this['slider'][stx_b('0xc9')]/this[stx_b('0x21e')]['sliderWrapperHeight'];if(g){var j=g['image'][stx_b('0x11a')]||g['image'][stx_b('0x1ad')];var k=g[stx_b('0x1ed')]['height']||g[stx_b('0x1ed')]['videoHeight'];var l=j/k;var m=l/ i;var n=0x1;if(m<0x1){n/=m;m=0x1;}this['uniforms'][stx_b('0x2b')][stx_b('0xc1')]=m;this[stx_b('0xd2')][stx_b('0x218')][stx_b('0xc1')]=n;}if(h){var o=h[stx_b('0x1ed')][stx_b('0x11a')]||h[stx_b('0x1ed')][stx_b('0x1ad')];var p=h[stx_b('0x1ed')][stx_b('0x1ee')]||h[stx_b('0x1ed')][stx_b('0x1b9')];var q=o/p;var r=q/ i;var s=0x1;if(r<0x1){s/=r;r=0x1;}this['uniforms'][stx_b('0x4d')][stx_b('0xc1')]=r;this['uniforms'][stx_b('0x14d')][stx_b('0xc1')]=s;}};this[stx_b('0x20d')]={};this[stx_b('0x1f8')]=function(g){if(this[stx_b('0x20d')][g])return this[stx_b('0x20d')][g];else{var k=!![];var l=0x0,m=0x0,o=0x0,p=0x0,q=0x3e8,s=0x3e8;switch(g){case stx_b('0x243'):s=0x1;o=q;break;case'right':s=0x1;l=q;break;case'bottomLeft':o=q;p=s;break;case stx_b('0x3f'):l=q;m=s;break;case stx_b('0x22b'):m=s;o=q;break;case stx_b('0x1e2'):l=q;p=s;break;case stx_b('0x1ff'):q=0x1;p=s;break;case stx_b('0x32'):q=0x1;m=s;break;default:k=![];}if(k){var u=document[stx_b('0x1c9')]('canvas');u[stx_b('0x11a')]=q;u[stx_b('0x1ee')]=s;var v=u[stx_b('0x13e')]('2d');var x=v[stx_b('0x48')](l,m,o,p);x[stx_b('0x92')](0x0,stx_b('0x51'));x['addColorStop'](0x1,stx_b('0x1df'));v[stx_b('0x241')]=x;v['fillRect'](0x0,0x0,q,s);var y=new THREE[(stx_b('0x1cb'))](u);this[stx_b('0x20d')][g]=y;return y;}else if(g==stx_b('0x1a9')){var u=document[stx_b('0x1c9')](stx_b('0x197'));u['width']=q;u[stx_b('0x1ee')]=s;var z=0x7;var v=u[stx_b('0x13e')]('2d');for(var A=0x0;A<z;A++){var B=Math['random']()*z;var x=v['createLinearGradient'](0x0,0x0,q,0x0);var B=Math[stx_b('0x11b')]()*0x100;x[stx_b('0x92')](0x0,'black');x['addColorStop'](0x1,stx_b('0x18c')+B+',\x20'+B+',\x20'+B+')');v[stx_b('0x241')]=x;v[stx_b('0x2c')](0x0,A*s/z,q,s/z);}var y=new THREE['CanvasTexture'](u);this[stx_b('0x20d')][g]=y;return y;}else if(g==stx_b('0x223')){var u=document[stx_b('0x1c9')](stx_b('0x197'));u[stx_b('0x11a')]=q;u[stx_b('0x1ee')]=s;var z=0x7;var v=u[stx_b('0x13e')]('2d');for(var A=0x0;A<z;A++){for(var C=0x0;C<z;C++){var x=v[stx_b('0x48')](0x0,0x0,q,0x0);var B=Math[stx_b('0x11b')]()*0x100;x[stx_b('0x92')](0x0,'black');x[stx_b('0x92')](0x1,stx_b('0x18c')+B+',\x20'+B+',\x20'+B+')');v[stx_b('0x241')]=x;v[stx_b('0x2c')](A*q/z,C*s/z,q/z,s/z);}}var y=new THREE['CanvasTexture'](u);this[stx_b('0x20d')][g]=y;return y;}else{return null;}}};this[stx_b('0x238')]=function(g){this[stx_b('0x73')]();};this[stx_b('0xa3')]=new THREE[(stx_b('0x11e'))]({'uniforms':this['uniforms'],'vertexShader':f[stx_b('0x204')],'fragmentShader':f[stx_b('0x8d')]});};STX[stx_b('0x1c8')][stx_b('0xf4')]=Object[stx_b('0xc2')](STX[stx_b('0x1d5')][stx_b('0xf4')]);STX['CrossfadeEffect'][stx_b('0xf4')]['constructor']=STX[stx_b('0x1c8')];STX[stx_b('0x1c8')]['prototype'][stx_b('0x57')]=function(a){a[stx_b('0xa3')]=this[stx_b('0xa3')];};STX[stx_b('0x1c8')][stx_b('0xf4')]['resetEffect']=function(a,b){this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a;if(b){this[stx_b('0xd2')][stx_b('0x193')][stx_b('0xc1')]=b;this[stx_b('0xd2')][stx_b('0x19b')]['value']=this[stx_b('0x1f8')]()||a[stx_b('0x19b')]||a;}this[stx_b('0x73')]();};STX[stx_b('0x1c8')][stx_b('0xf4')][stx_b('0x139')]=function(a){var b=a[stx_b('0x139')];this[stx_b('0xd2')]['u4'][stx_b('0xc1')]=b<=0x0?0x1:-0x1;var c=a[stx_b('0x175')];var d=0x1;var e=0x1;if(a[stx_b('0x7b')][stx_b('0x88')]==stx_b('0x1de'))e*=-0x1;if(b>0x0)e*=-0x1;if(e==0x1){this[stx_b('0xd2')][stx_b('0x19b')][stx_b('0xc1')]=this[stx_b('0x1f8')](a['direction'])||a[stx_b('0x159')][stx_b('0x19b')]||a['textureFrom'];}else if(a['textureTo']){this[stx_b('0xd2')]['alphaMap']['value']=this[stx_b('0x1f8')](a[stx_b('0x88')])||a[stx_b('0x90')]['alphaMap']||a[stx_b('0x90')];}b=Math[stx_b('0x229')](b);b=Math[stx_b('0x20e')](b);this[stx_b('0x1ac')]=b;this['uniforms']['u1'][stx_b('0xc1')]=0x1-b;if(typeof a[stx_b('0x7b')][stx_b('0x177')]!=stx_b('0x200'))this[stx_b('0xd2')]['u2'][stx_b('0xc1')]=a[stx_b('0x7b')]['distance'];this[stx_b('0xd2')]['u5'][stx_b('0xc1')]=a[stx_b('0x7b')][stx_b('0x13b')]||0x0;this[stx_b('0xd2')]['u6'][stx_b('0xc1')]=a['cSlide'][stx_b('0x185')]||0x0;};STX['CrossfadeEffect'][stx_b('0xf4')][stx_b('0x1a')]=function(a,b){if(this['uniforms']['u1']['value']==0x0)this[stx_b('0xd2')]['u1'][stx_b('0xc1')]=0x1;this['options']=a;this[stx_b('0xd2')]['transitionFrom'][stx_b('0xc1')]=a[stx_b('0xb8')];this[stx_b('0xd2')][stx_b('0x193')][stx_b('0xc1')]=a['sliderTextureTo'];this[stx_b('0x240')]=a[stx_b('0xb8')];this[stx_b('0x193')]=a[stx_b('0xd4')];this['updateScale']();this['uniforms'][stx_b('0x19b')][stx_b('0xc1')]=a[stx_b('0xb8')][stx_b('0x19b')]||a[stx_b('0xb8')];this['transitionTo']=a[stx_b('0xd4')];this['pauseVideoCallback']=b;if(typeof a['distance']!=stx_b('0x200'))this[stx_b('0xd2')]['u2']['value']=a[stx_b('0x177')];this[stx_b('0xd2')]['u5'][stx_b('0xc1')]=a['offset1']||0x0;this['uniforms']['u6'][stx_b('0xc1')]=a[stx_b('0x185')]||0x0;var c=a['slideFrom']-a[stx_b('0x1ab')]==0x1;var e=a[stx_b('0x3b')][stx_b('0x1cf')]();var f=0x1,g=0x1,h=0x1;this[stx_b('0x1f0')][stx_b('0x1f2')](function(n){if(e[stx_b('0x232')](n)!==-0x1)a[stx_b('0x88')]=n;});if(!a[stx_b('0x88')]){a[stx_b('0x88')]='in';}var i=stx_b('0xb6');if(e[stx_b('0x232')](stx_b('0x128'))!==-0x1||a[stx_b('0xf3')]==='slow'){i=stx_b('0xa2');}if(e[stx_b('0x232')](stx_b('0x5a'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x5a')){i='Expo';}var j=stx_b('0x11f')+i;var k=a[stx_b('0xc5')]*(0x1-this[stx_b('0x1ac')]);if(a[stx_b('0x88')]===stx_b('0x1de'))f*=-0x1;if(c)f*=-0x1;this[stx_b('0xd2')]['u4'][stx_b('0xc1')]=c?-0x1:0x1;this[stx_b('0xd2')][stx_b('0x19b')]['value']=f==0x1?this[stx_b('0x1f8')](a[stx_b('0x88')])||a[stx_b('0xb8')][stx_b('0x19b')]||a[stx_b('0xb8')]:this[stx_b('0x1f8')](a[stx_b('0x88')])||a[stx_b('0xd4')][stx_b('0x19b')]||a[stx_b('0xd4')];var l=this;var m={'u1':this['uniforms']['u1']['value']};anime({'targets':m,'u1':0x0,'change':function(){for(var n in m){l[stx_b('0xd2')][n][stx_b('0xc1')]=m[n];}},'duration':k,'easing':j,'complete':function(){l[stx_b('0xd2')]['u1'][stx_b('0xc1')]=0x0;l[stx_b('0x217')]();}});};STX[stx_b('0x100')]={'zoom':{'name':stx_b('0x4a'),'effect':stx_b('0x69'),'duration':0x2bc,'distance':0x5,'easing':stx_b('0x128'),'blur':0x3,'brightness':0x1,'direction':'in'},'roll':{'name':stx_b('0x14c'),'effect':stx_b('0x106'),'duration':0x2bc,'distance':1.5,'easing':'slow','blur':0x2,'brightness':0x1,'direction':stx_b('0x243')},'warp':{'name':stx_b('0xf8'),'effect':stx_b('0x5e'),'duration':0x4b0,'distance':1.5,'easing':'slow','blur':0x2,'brightness':0x1,'direction':stx_b('0x243')},'stretch':{'name':'Stretch','effect':'stretch','duration':0x4b0,'distance':0x1,'easing':stx_b('0x128'),'blur':0x2,'brightness':0x1,'direction':'left'},'slide':{'name':stx_b('0xce'),'effect':stx_b('0xa9'),'duration':0x2bc,'distance':0x1,'easing':stx_b('0x128'),'blur':0x0,'brightness':0x1,'direction':stx_b('0x243')},'line':{'name':'Line','effect':stx_b('0x37'),'duration':0x2bc,'distance':0x1,'easing':stx_b('0x128'),'blur':0x0,'brightness':0x1,'direction':stx_b('0xe7')},'fade':{'name':stx_b('0x23b'),'effect':stx_b('0x230'),'duration':0x3e8,'distance':0x1,'easing':stx_b('0x128'),'blur':0x0,'brightness':0x1,'direction':'in'},'fade2':{'name':stx_b('0x10d'),'effect':stx_b('0x15c'),'duration':0x5dc,'distance':0x1,'easing':stx_b('0x128'),'blur':0x0,'brightness':0x0,'direction':'in'},'powerzoom':{'name':stx_b('0x156'),'effect':stx_b('0x69'),'duration':0x2bc,'distance':0xf,'easing':stx_b('0x128'),'blur':0x5,'brightness':0x3,'direction':'in'},'blur':{'name':stx_b('0x61'),'effect':stx_b('0x106'),'duration':0x1f4,'distance':0.01,'easing':stx_b('0x128'),'blur':0x3,'brightness':0x1,'direction':stx_b('0x243')},'twirl':{'name':'Twirl','effect':stx_b('0x1fd'),'duration':0x3e8,'distance':0x1,'easing':stx_b('0x128'),'blur':0x0,'brightness':0x1,'direction':stx_b('0x243')},'line2':{'name':stx_b('0x17d'),'effect':'line','duration':0x2bc,'easing':stx_b('0x128'),'direction':stx_b('0x17e')},'line3':{'name':stx_b('0x153'),'effect':'line','duration':0x2bc,'easing':'slow','direction':stx_b('0x123')},'line4':{'name':stx_b('0x1f5'),'effect':stx_b('0x37'),'duration':0x2bc,'easing':stx_b('0x128'),'direction':stx_b('0x174')},'line5':{'name':stx_b('0x14'),'effect':stx_b('0x37'),'duration':0x2bc,'easing':stx_b('0x128'),'direction':stx_b('0x31')},'line6':{'name':stx_b('0x187'),'effect':stx_b('0x37'),'duration':0x2bc,'easing':stx_b('0x128'),'direction':stx_b('0xe8')},'line7':{'name':stx_b('0x67'),'effect':stx_b('0x37'),'duration':0x2bc,'easing':stx_b('0x128'),'direction':stx_b('0x49')},'line8':{'name':stx_b('0x19d'),'effect':stx_b('0x37'),'duration':0x2bc,'easing':stx_b('0x128'),'direction':'middle2'},'line9':{'name':stx_b('0xfe'),'effect':stx_b('0x37'),'duration':0x2bc,'easing':stx_b('0x128'),'direction':stx_b('0x7e')},'line10':{'name':stx_b('0xbf'),'effect':'line','duration':0x2bc,'easing':stx_b('0x128'),'direction':stx_b('0x2e')},'crossfade1':{'name':stx_b('0x226'),'effect':'crossfade','duration':0x3e8,'distance':0.3,'easing':'slow','direction':stx_b('0x243')},'crossfade2':{'name':stx_b('0x143'),'effect':'crossfade','duration':0x3e8,'distance':0.3,'easing':stx_b('0x128'),'direction':stx_b('0x22b')},'crossfade3':{'name':stx_b('0x1c7'),'effect':stx_b('0x230'),'duration':0x3e8,'distance':0.3,'easing':stx_b('0x128'),'direction':stx_b('0x82')},'crossfade4':{'name':'Crossfade\x205','effect':stx_b('0x230'),'duration':0x3e8,'distance':0.3,'easing':'slow','direction':stx_b('0x32')},'roll2':{'name':stx_b('0x45'),'effect':stx_b('0x106'),'duration':0x1f4,'distance':0.5,'easing':stx_b('0x128'),'blur':0x4,'brightness':0x1,'direction':stx_b('0x243')},'roll3':{'name':'Down\x20short','effect':stx_b('0x106'),'duration':0x1f4,'distance':0.5,'easing':stx_b('0x128'),'blur':0x4,'brightness':0x1,'direction':'down'},'roll4':{'name':'Left','effect':stx_b('0x106'),'duration':0x320,'distance':0x1,'easing':stx_b('0x128'),'blur':0x4,'brightness':0x1,'direction':stx_b('0x243')},'roll5':{'name':stx_b('0xb9'),'effect':stx_b('0x106'),'duration':0x320,'distance':0x1,'easing':stx_b('0x128'),'blur':0x4,'brightness':0x1,'direction':stx_b('0x120')},'zoom2':{'name':'Zoom\x20in\x20short','effect':stx_b('0x69'),'duration':0x1f4,'distance':0x2,'easing':stx_b('0x128'),'blur':0x2,'brightness':0x1,'direction':'in'},'zoom3':{'name':stx_b('0x19'),'effect':stx_b('0x69'),'duration':0x1f4,'distance':0x2,'easing':'slow','blur':0x2,'brightness':0x1,'direction':stx_b('0x1de')},'zoom4':{'name':'Zoom\x20in','effect':stx_b('0x69'),'duration':0x320,'distance':2.5,'easing':stx_b('0x128'),'blur':0x3,'brightness':0x1,'direction':'in'},'zoom5':{'name':stx_b('0xa5'),'effect':stx_b('0x69'),'duration':0x320,'distance':2.5,'easing':stx_b('0x128'),'blur':0x3,'brightness':0x1,'direction':stx_b('0x1de')},'blur2':{'name':stx_b('0x9'),'effect':stx_b('0x106'),'duration':0x320,'distance':0.01,'easing':stx_b('0x128'),'blur':0x1,'brightness':0x3,'direction':stx_b('0x22b')},'blur3':{'name':'Blur\x20fade','effect':stx_b('0x106'),'duration':0x320,'distance':0.01,'easing':stx_b('0x128'),'blur':0x1,'brightness':0.3,'direction':stx_b('0x22b')},'blur4':{'name':stx_b('0x1c5'),'effect':stx_b('0x106'),'duration':0x1f4,'distance':0.1,'easing':'slow','blur':0x2,'brightness':0x3,'direction':'left'},'blur5':{'name':'Blur\x20fade\x20left','effect':'roll','duration':0x1f4,'distance':0.1,'easing':stx_b('0x128'),'blur':0x2,'brightness':0.3,'direction':stx_b('0x243')},'blur6':{'name':stx_b('0x1d'),'effect':stx_b('0x106'),'duration':0x1f4,'distance':0.1,'easing':stx_b('0x128'),'blur':0x2,'brightness':0x3,'direction':'up'},'blur7':{'name':stx_b('0xaf'),'effect':stx_b('0x106'),'duration':0x1f4,'distance':0.1,'easing':stx_b('0x128'),'blur':0x2,'brightness':0.3,'direction':'up'}};STX[stx_b('0x1a1')]=function(a,b,c,d,e){STX['Effect']['call'](this,c);this['slider']=c[0x0];e=this[stx_b('0x9c')](e);this['direction']=e;if(STX['LineShader']===undefined)console['error'](stx_b('0x4b'));var f=STX[stx_b('0xb4')];f[stx_b('0x8d')]=f['fragmentShader'][stx_b('0x231')](stx_b('0x179'),e);this[stx_b('0xd8')]=f;this[stx_b('0xd2')]=THREE[stx_b('0x1ba')][stx_b('0xc8')](f['uniforms']);this[stx_b('0x1ac')]=0x0;this['blur']=0x1;if(a!==undefined)this[stx_b('0xd2')][stx_b('0x240')]['value']=a;if(b!==undefined)this[stx_b('0xd2')][stx_b('0x193')][stx_b('0xc1')]=b;this[stx_b('0x73')]=function(){var g=this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')];var h=this['uniforms'][stx_b('0x193')][stx_b('0xc1')];var i=this[stx_b('0x21e')]['sliderWrapperWidth']/this[stx_b('0x21e')][stx_b('0x221')];if(g){var j=g['image'][stx_b('0x11a')]||g['image'][stx_b('0x1ad')];var k=g[stx_b('0x1ed')][stx_b('0x1ee')]||g[stx_b('0x1ed')]['videoHeight'];var l=j/k;var m=l/ i;var n=0x1;if(m<0x1){n/=m;m=0x1;}this[stx_b('0xd2')][stx_b('0x2b')][stx_b('0xc1')]=m;this[stx_b('0xd2')][stx_b('0x218')]['value']=n;}if(h){var o=h['image']['width']||h[stx_b('0x1ed')][stx_b('0x1ad')];var p=h[stx_b('0x1ed')][stx_b('0x1ee')]||h['image'][stx_b('0x1b9')];var q=o/p;var r=q/ i;var s=0x1;if(r<0x1){s/=r;r=0x1;}this[stx_b('0xd2')][stx_b('0x4d')][stx_b('0xc1')]=r;this['uniforms'][stx_b('0x14d')][stx_b('0xc1')]=s;}};this['setSize']=function(g){this['updateScale']();};this[stx_b('0xa3')]=new THREE['ShaderMaterial']({'uniforms':this[stx_b('0xd2')],'vertexShader':f[stx_b('0x204')],'fragmentShader':f[stx_b('0x8d')]});};STX[stx_b('0x1a1')]['prototype']=Object[stx_b('0xc2')](STX[stx_b('0x1d5')][stx_b('0xf4')]);STX[stx_b('0x1a1')]['prototype'][stx_b('0xef')]=STX[stx_b('0x1a1')];STX['LineEffect']['prototype'][stx_b('0x9c')]=function(a){switch(a){case stx_b('0xe7'):a='x\x20>\x201.\x20-\x20a';break;case stx_b('0x17e'):a=stx_b('0x3d');break;case stx_b('0x108'):a='y\x20<\x20(5.\x20*\x20(x\x20-\x201.)\x20+\x206.\x20*\x20a)';break;case stx_b('0x168'):a=stx_b('0x8c');break;case'left5':a=stx_b('0x1f6');break;case stx_b('0x174'):a=stx_b('0x146');break;case'up2':a='y\x20<\x20(.1\x20*\x20(x\x20-\x201.)\x20+\x20a\x20*\x201.1)';break;case stx_b('0x1c0'):a='y\x20<\x20(.2\x20*\x20(x\x20-\x201.)\x20+\x20a\x20*\x201.2)';break;case stx_b('0x189'):a=stx_b('0x63');break;case stx_b('0xe8'):a=stx_b('0x194');break;case stx_b('0x49'):a=stx_b('0x154');break;case stx_b('0x115'):a=stx_b('0x148');break;case stx_b('0x7e'):a=stx_b('0x206');break;case'middle4':a=stx_b('0x6a');break;default:a=stx_b('0x1dd');break;}return a;};STX[stx_b('0x1a1')]['prototype'][stx_b('0x139')]=function(a){var b=a[stx_b('0x139')];var c=a[stx_b('0x175')];this[stx_b('0xd2')]['u5'][stx_b('0xc1')]=b;this[stx_b('0x1ac')]=Math[stx_b('0x229')](a['progress']);var d=a['direction'];d=this['handleDirection'](d);if(this['direction']!=d){this['material'][stx_b('0x8d')]=this[stx_b('0xa3')][stx_b('0x8d')]['replace'](this[stx_b('0x88')],d);this[stx_b('0xa3')][stx_b('0x180')]=!![];this[stx_b('0x88')]=d;}};STX[stx_b('0x1a1')][stx_b('0xf4')][stx_b('0x57')]=function(a){a[stx_b('0xa3')]=this[stx_b('0xa3')];};STX['LineEffect'][stx_b('0xf4')]['resetEffect']=function(a,b){this['uniforms'][stx_b('0x240')]['value']=a;if(b){this[stx_b('0xd2')][stx_b('0x193')][stx_b('0xc1')]=b;this[stx_b('0x73')]();}};STX['LineEffect'][stx_b('0xf4')]['animate']=function(a,b){var c=a['direction'];c=this[stx_b('0x9c')](c);if(this[stx_b('0x88')]!=c){this[stx_b('0xa3')]['fragmentShader']=this['material']['fragmentShader'][stx_b('0x231')](this[stx_b('0x88')],c);this[stx_b('0xa3')]['needsUpdate']=!![];this[stx_b('0x88')]=c;}this[stx_b('0x83')]=a;this['blur']=typeof a['blur']!=stx_b('0x200')?a[stx_b('0x35')]:0x1;this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a[stx_b('0xb8')];this['uniforms'][stx_b('0x193')]['value']=a[stx_b('0xd4')];this[stx_b('0x73')]();this['transitionFrom']=a[stx_b('0xb8')];this['transitionTo']=a[stx_b('0xd4')];this[stx_b('0x103')]=b;var d=a['slideFrom']-a[stx_b('0x1ab')]==0x1||a[stx_b('0x210')];var e=a['transitionEffect'][stx_b('0x1cf')]();var f=-0x1;var g=stx_b('0x1b');if(e[stx_b('0x232')](stx_b('0x128'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x128')){g=stx_b('0xee');}if(e[stx_b('0x232')]('elastic')!==-0x1||a[stx_b('0xf3')]===stx_b('0x117')){g='easeInOutElastic(1,\x20.4)';}if(this[stx_b('0xd2')]['u5'][stx_b('0xc1')]!=0x0&&this[stx_b('0xd2')]['u5']['value']!=0x1){g=stx_b('0x7f');}if(d){f*=-0x1;this[stx_b('0x73')]();}if(f==0x1&&this[stx_b('0xd2')]['u5'][stx_b('0xc1')]==0x1)this[stx_b('0xd2')]['u5'][stx_b('0xc1')]=0x0;else if(f==0x0&&this[stx_b('0xd2')]['u5'][stx_b('0xc1')]==0x0)this[stx_b('0xd2')]['u5']['value']=0x1;var h={'u5':f,'time':a[stx_b('0xc5')]};h['t']=h[stx_b('0x228')]*Math[stx_b('0x229')](f-this['uniforms']['u5'][stx_b('0xc1')]);var i=this;anime({'targets':this[stx_b('0xd2')]['u5'],'value':f,'duration':h['t'],'easing':g,'complete':function(){i[stx_b('0xd2')]['u5']['value']=0x0;i[stx_b('0x155')]();i[stx_b('0x217')]();}});};STX[stx_b('0x1a1')][stx_b('0xf4')][stx_b('0x155')]=function(){this[stx_b('0xd2')]['transitionFrom'][stx_b('0xc1')]=this['transitionTo'];this[stx_b('0xd2')]['transitionTo'][stx_b('0xc1')]=this[stx_b('0x240')];this['updateScale']();this[stx_b('0x103')]();this[stx_b('0x20a')]();};STX['PowerzoomEffect']=function(a,b,c){STX[stx_b('0x1d5')][stx_b('0x12a')](this,c);if(STX[stx_b('0x149')]===undefined)console[stx_b('0x17f')](stx_b('0x1c6'));var d=STX[stx_b('0x149')];this[stx_b('0xd2')]=THREE[stx_b('0x1ba')][stx_b('0xc8')](d[stx_b('0xd2')]);this[stx_b('0x1ac')]=0x0;this[stx_b('0x1f0')]=['in',stx_b('0x1de')];if(a!==undefined)this['uniforms']['transitionFrom'][stx_b('0xc1')]=a;this[stx_b('0xa3')]=new THREE[(stx_b('0x11e'))]({'uniforms':this['uniforms'],'vertexShader':d[stx_b('0x204')],'fragmentShader':d[stx_b('0x8d')]});};STX['PowerzoomEffect'][stx_b('0xf4')]=Object[stx_b('0xc2')](STX['Effect']['prototype']);STX[stx_b('0x1d7')]['prototype'][stx_b('0xef')]=STX['PowerzoomEffect'];STX[stx_b('0x1d7')]['prototype'][stx_b('0x57')]=function(a){a['material']=this[stx_b('0xa3')];};STX[stx_b('0x1d7')]['prototype'][stx_b('0x133')]=function(a){this[stx_b('0xd2')]['transitionFrom'][stx_b('0xc1')]=a;};STX[stx_b('0x1d7')][stx_b('0xf4')][stx_b('0x139')]=function(a){var b=a[stx_b('0x139')];var c=a[stx_b('0x175')];var d=0x1;if(b==0x0)return;this[stx_b('0xd2')]['u2'][stx_b('0xc1')]=0x96;if(b<0x0){this['uniforms']['u4'][stx_b('0xc1')]=b/0xf;}else{this['uniforms']['u1'][stx_b('0xc1')]=0x1-b;this[stx_b('0xd2')]['u4'][stx_b('0xc1')]=-b/0x1e;}this[stx_b('0x1ac')]=Math[stx_b('0x229')](a[stx_b('0x139')]);if(c[stx_b('0x232')](stx_b('0x203'))!==-0x1)d=0xa;if(c[stx_b('0x232')](stx_b('0x26'))!==-0x1)d=0x0;if(typeof a[stx_b('0x15c')]!=stx_b('0x200'))d=a[stx_b('0x15c')];this['uniforms']['u5'][stx_b('0xc1')]=0x1+(d-0x1)*this[stx_b('0x1ac')];};STX['PowerzoomEffect'][stx_b('0xf4')][stx_b('0x1a')]=function(a,b){var c=this;this[stx_b('0x83')]=a;this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a[stx_b('0xb8')];this['transitionTo']=a[stx_b('0xd4')];this[stx_b('0x103')]=b;var d=a[stx_b('0xd6')]-a[stx_b('0x1ab')]==0x1;var e=a[stx_b('0x3b')][stx_b('0x1cf')]();var f=0x1e;var g=0x1;this[stx_b('0x1f0')][stx_b('0x1f2')](function(r){if(e[stx_b('0x232')](r)!==-0x1)a[stx_b('0x88')]=r;});if(e['indexOf'](stx_b('0x203'))!==-0x1||a[stx_b('0x15c')]===stx_b('0x203'))g=0xa;if(e[stx_b('0x232')](stx_b('0x26'))!==-0x1||a[stx_b('0x15c')]===stx_b('0x26'))g=0x0;if(a['direction']=='random'){var h=STX[stx_b('0x11')][stx_b('0x1bf')](0x0,0x1);a[stx_b('0x88')]=this[stx_b('0x1f0')][h];}else if(!a[stx_b('0x88')]){a[stx_b('0x88')]='in';}if(typeof a[stx_b('0x177')]==stx_b('0x1f'))f=a[stx_b('0x177')];if(typeof a[stx_b('0x15c')]==stx_b('0x1f'))g=a[stx_b('0x15c')];var i=stx_b('0x157');if(e[stx_b('0x232')](stx_b('0x128'))!==-0x1||a[stx_b('0xf3')]==='slow'){i=stx_b('0x225');}if(e[stx_b('0x232')](stx_b('0x5a'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x5a')){i=stx_b('0xc3');}if(e[stx_b('0x232')](stx_b('0x117'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x117')){i=stx_b('0x12');}var j=stx_b('0x18a')+i;var k=stx_b('0x11f')+i;var l={'time1':0.6*a[stx_b('0xc5')],'time2':0.4*a[stx_b('0xc5')],'scale1':0x1,'scale2':0x1,'blur':0x0,'a1':0x0,'a2':0x0,'brightness':g};function m(){l['scale1']=0x1;l[stx_b('0x142')]=0.5;l[stx_b('0x35')]=0x1;l[stx_b('0x3c')]=-0x1;l[stx_b('0xe0')]=-0x1;l['a1']=0x96;p();}function n(){l['scale1']=0.5;l[stx_b('0x142')]=0x1;l['blur']=0x1;l[stx_b('0x3c')]=-0x1;l[stx_b('0xe0')]=-0x2;l['a2']=0x96;p();}function p(){var r={'u1':c['uniforms']['u1']['value'],'u2':l['a1'],'u3':0x0,'u4':c[stx_b('0xd2')]['u4']['value'],'u5':c[stx_b('0xd2')]['u5'][stx_b('0xc1')]};anime({'targets':r,'u1':l[stx_b('0x85')],'u3':l[stx_b('0x35')],'u4':l[stx_b('0x3c')],'u5':l[stx_b('0x15c')],'change':function(){for(var t in r){c[stx_b('0xd2')][t]['value']=r[t];}},'duration':l[stx_b('0xd1')],'easing':j,'complete':function(){c[stx_b('0x155')]();}});var s={'u1':l[stx_b('0x142')],'u2':l['a2'],'u3':l[stx_b('0x35')],'u4':l[stx_b('0xe0')],'u5':l[stx_b('0x15c')]};anime({'targets':s,'u1':0x1,'u3':0x0,'u4':0x0,'u5':0x1,'change':function(){for(var t in r){c[stx_b('0xd2')][t][stx_b('0xc1')]=r[t];}},'duration':l[stx_b('0x77')],'delay':l[stx_b('0xd1')],'easing':j,'complete':function(){c[stx_b('0x217')]();}});}var q=0x1;if(a[stx_b('0x88')]===stx_b('0x1de'))q*=-0x1;if(d)q*=-0x1;if(q==0x1){m();}else{n();}};STX[stx_b('0x1d7')]['prototype'][stx_b('0x155')]=function(){this['uniforms']['transitionFrom']['value']=this[stx_b('0x193')];this['pauseVideoCallback']();this[stx_b('0x20a')]();};STX[stx_b('0xdb')]=function(a,b,c,d){STX[stx_b('0x1d5')][stx_b('0x12a')](this,c);this[stx_b('0x23c')]=d['hBlur1'];this['blurX_2']=d['hBlur2'];this['blurY_1']=d['vBlur1'];this[stx_b('0x17a')]=d['vBlur2'];this['fisheye']=d['fisheyePass'];this[stx_b('0x35')]=0x1;this['progressVal']=0x0;if(STX[stx_b('0xc7')]===undefined)console[stx_b('0x17f')](stx_b('0xd7'));var e=STX[stx_b('0xc7')];this[stx_b('0xd2')]=THREE[stx_b('0x1ba')]['clone'](e[stx_b('0xd2')]);this[stx_b('0x1f0')]=['top',stx_b('0x1ff'),stx_b('0x243'),stx_b('0x136')];if(a!==undefined)this[stx_b('0xd2')][stx_b('0x240')]['value']=a;this[stx_b('0xa3')]=new THREE['ShaderMaterial']({'uniforms':this[stx_b('0xd2')],'vertexShader':e[stx_b('0x204')],'fragmentShader':e['fragmentShader']});};STX[stx_b('0xdb')][stx_b('0xf4')]=Object[stx_b('0xc2')](STX[stx_b('0x1d5')][stx_b('0xf4')]);STX['RollEffect'][stx_b('0xf4')][stx_b('0xef')]=STX['RollEffect'];STX[stx_b('0xdb')][stx_b('0xf4')][stx_b('0x57')]=function(a,b){a[stx_b('0xa3')]=this[stx_b('0xa3')];if(this[stx_b('0xd2')]['u3']['value']==0x0){this['blurX_1'][stx_b('0xae')]=this[stx_b('0x1')][stx_b('0xae')]=![];}else{this[stx_b('0x23c')][stx_b('0xae')]=this[stx_b('0x1')][stx_b('0xae')]=!![];this[stx_b('0x23c')][stx_b('0xd2')]['h'][stx_b('0xc1')]=this[stx_b('0xd2')]['u3']['value'];this[stx_b('0x1')]['uniforms']['h']['value']=this[stx_b('0x23c')][stx_b('0xd2')]['h'][stx_b('0xc1')]*1.4;}if(this[stx_b('0xd2')]['u4'][stx_b('0xc1')]==0x0){this['blurY_1'][stx_b('0xae')]=this[stx_b('0x17a')][stx_b('0xae')]=![];}else{this[stx_b('0xb2')]['enabled']=this[stx_b('0x17a')][stx_b('0xae')]=!![];this[stx_b('0xb2')][stx_b('0xd2')]['h'][stx_b('0xc1')]=this[stx_b('0xd2')]['u4']['value'];this[stx_b('0x17a')][stx_b('0xd2')]['h'][stx_b('0xc1')]=this[stx_b('0xb2')][stx_b('0xd2')]['h']['value']*1.4;}};STX[stx_b('0xdb')][stx_b('0xf4')][stx_b('0x133')]=function(a){this['uniforms'][stx_b('0x240')][stx_b('0xc1')]=a;};STX[stx_b('0xdb')][stx_b('0xf4')][stx_b('0x139')]=function(a){var b=a[stx_b('0x139')];var c=a[stx_b('0x175')];var d=0x1;this[stx_b('0xd2')]['u5'][stx_b('0xc1')]=b/0x2;this[stx_b('0x1ac')]=Math[stx_b('0x229')](a['progress']);if(c[stx_b('0x232')](stx_b('0x203'))!==-0x1)d=0xa;if(c['indexOf'](stx_b('0x26'))!==-0x1)d=0x0;if(typeof a[stx_b('0x15c')]!=stx_b('0x200'))d=a[stx_b('0x15c')];this[stx_b('0xd2')]['u7'][stx_b('0xc1')]=0x1+(d-0x1)*this[stx_b('0x1ac')];};STX['RollEffect'][stx_b('0xf4')][stx_b('0x1a')]=function(a,b){this[stx_b('0x83')]=a;this[stx_b('0x35')]=typeof a['blur']!=stx_b('0x200')?a[stx_b('0x35')]:0x1;this[stx_b('0xd2')][stx_b('0x240')]['value']=a[stx_b('0xb8')];this[stx_b('0x193')]=a[stx_b('0xd4')];this[stx_b('0x103')]=b;var c=a[stx_b('0xd6')]-a[stx_b('0x1ab')]==0x1;var e=a[stx_b('0x3b')][stx_b('0x1cf')]();var f=1.5,g=0x1,h=0x0,i=0x0;this[stx_b('0x1f0')][stx_b('0x1f2')](function(w){if(e[stx_b('0x232')](w)!==-0x1)a[stx_b('0x88')]=w;});if(e[stx_b('0x232')](stx_b('0xd3'))!==-0x1||a[stx_b('0x177')]==='long')f=2.5;if(e['indexOf'](stx_b('0x1b0'))!==-0x1||a[stx_b('0x177')]===stx_b('0x1b0'))f=0x1;if(e[stx_b('0x232')](stx_b('0x203'))!==-0x1||a[stx_b('0x15c')]==='flash')g=0xa;if(e['indexOf']('fade')!==-0x1||a[stx_b('0x15c')]===stx_b('0x26'))g=0x0;if(a[stx_b('0x88')]){a[stx_b('0x88')]=a[stx_b('0x88')]['replace']('up',stx_b('0x32'))[stx_b('0x231')]('down',stx_b('0x1ff'));if(a[stx_b('0x88')]==stx_b('0x11b')){var j=STX[stx_b('0x11')][stx_b('0x1bf')](0x0,0x3);a[stx_b('0x88')]=this['directions'][j];}}else{a[stx_b('0x88')]='left';}var k=a['direction'][stx_b('0x1cf')]();if(k[stx_b('0x232')](stx_b('0x32'))!==-0x1)i=0x1;if(k[stx_b('0x232')](stx_b('0x1ff'))!==-0x1)i=-0x1;if(k[stx_b('0x232')](stx_b('0x243'))!==-0x1)h=-0x1;if(k[stx_b('0x232')](stx_b('0x136'))!==-0x1)h=0x1;if(typeof a[stx_b('0x177')]=='number')f=a['distance'];if(typeof a[stx_b('0x15c')]==stx_b('0x1f'))g=a['brightness'];var l=stx_b('0x157');if(e['indexOf'](stx_b('0x128'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x128')){l='Cubic';}if(e[stx_b('0x232')](stx_b('0x5a'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x5a')){l=stx_b('0xc3');}if(e['indexOf'](stx_b('0x117'))!==-0x1||a[stx_b('0xf3')]==='elastic'){l=stx_b('0x12');}var m=stx_b('0x18a')+l;var n=stx_b('0x11f')+l;var o=a['transitionDuration']*(0x1-this[stx_b('0x1ac')]);var p=o*0.5,q=o*0.5;if(this['uniforms']['u5'][stx_b('0xc1')]!=0x0){h=-0x1;i=0x0;p=o*0.1;q=o*0.9;}h*=f;i*=f;if(c){h*=-0x1;i*=-0x1;}var r={'u3':0x0,'u4':0x0,'u5':this[stx_b('0xd2')]['u5'][stx_b('0xc1')],'u6':0x0,'u7':this[stx_b('0xd2')]['u7'][stx_b('0xc1')]};var s=h!=0x0?this[stx_b('0x35')]*0.01:0x0;var t=i!=0x0?this[stx_b('0x35')]*0.01:0x0;var u=this;anime({'targets':r,'u3':s,'u4':t,'u5':h,'u6':i,'u7':g,'change':function(){for(var w in r){u[stx_b('0xd2')][w][stx_b('0xc1')]=r[w];}},'duration':p,'easing':m,'complete':function(){u[stx_b('0x155')]();}});var v={'u3':s,'u4':t,'u5':-h,'u6':-i,'u7':g};anime({'targets':v,'u3':0x0,'u4':0x0,'u5':0x0,'u6':0x0,'u7':0x1,'change':function(){for(var w in v){u[stx_b('0xd2')][w]['value']=v[w];}},'duration':q,'delay':p,'easing':n,'complete':function(){u[stx_b('0xd2')]['u3'][stx_b('0xc1')]=0x0;u[stx_b('0xd2')]['u4'][stx_b('0xc1')]=0x0;u[stx_b('0xd2')]['u5'][stx_b('0xc1')]=0x0;u[stx_b('0xd2')]['u6'][stx_b('0xc1')]=0x0;u[stx_b('0x217')]();}});};STX[stx_b('0xdb')][stx_b('0xf4')]['switchTexture']=function(){this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=this[stx_b('0x193')];this[stx_b('0x103')]();this[stx_b('0x20a')]();};STX['SlideEffect']=function(a,b,c,d){STX[stx_b('0x1d5')]['call'](this,c);this[stx_b('0x21e')]=c[0x0];this[stx_b('0x23c')]=d[stx_b('0x1f7')];this[stx_b('0x1')]=d[stx_b('0x18f')];if(STX[stx_b('0x119')]===undefined)console['error']('STX.SlideEffect\x20relies\x20on\x20STX.SlideShader');var e=STX[stx_b('0x119')];this[stx_b('0xd2')]=THREE[stx_b('0x1ba')][stx_b('0xc8')](e[stx_b('0xd2')]);this[stx_b('0x1ac')]=0x0;this[stx_b('0x35')]=0x1;this['directions']=[stx_b('0x243'),'right'];if(a!==undefined)this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a;if(b!==undefined)this[stx_b('0xd2')]['transitionTo']['value']=b;this[stx_b('0x73')]=function(){var f=this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')];var g=this[stx_b('0xd2')][stx_b('0x193')][stx_b('0xc1')];var h=this[stx_b('0x21e')]['sliderWrapperWidth']/this[stx_b('0x21e')]['sliderWrapperHeight'];if(f){var i=f[stx_b('0x1ed')]['width']||f[stx_b('0x1ed')][stx_b('0x1ad')];var j=f[stx_b('0x1ed')][stx_b('0x1ee')]||f[stx_b('0x1ed')]['videoHeight'];var k=i/j;var l=k/h;var m=0x1;if(l<0x1){m/=l;l=0x1;}this['uniforms'][stx_b('0x2b')][stx_b('0xc1')]=l;this[stx_b('0xd2')][stx_b('0x218')][stx_b('0xc1')]=m;}if(g){var n=g[stx_b('0x1ed')][stx_b('0x11a')]||g[stx_b('0x1ed')]['videoWidth'];var o=g[stx_b('0x1ed')]['height']||g[stx_b('0x1ed')][stx_b('0x1b9')];var p=n/o;var q=p/h;var r=0x1;if(q<0x1){r/=q;q=0x1;}this[stx_b('0xd2')][stx_b('0x4d')][stx_b('0xc1')]=q;this[stx_b('0xd2')]['sy2'][stx_b('0xc1')]=r;}};this['setSize']=function(f){this[stx_b('0x73')]();};this[stx_b('0xa3')]=new THREE[(stx_b('0x11e'))]({'uniforms':this[stx_b('0xd2')],'vertexShader':e[stx_b('0x204')],'fragmentShader':e[stx_b('0x8d')]});};STX[stx_b('0x1c2')][stx_b('0xf4')]=Object[stx_b('0xc2')](STX[stx_b('0x1d5')][stx_b('0xf4')]);STX['SlideEffect'][stx_b('0xf4')][stx_b('0xef')]=STX[stx_b('0x1c2')];STX[stx_b('0x1c2')]['prototype'][stx_b('0x139')]=function(a){var b=a[stx_b('0x139')];var c=a['name'];var d=0x1;this[stx_b('0xd2')]['u5'][stx_b('0xc1')]=b;this[stx_b('0x1ac')]=Math['abs'](a[stx_b('0x139')]);if(c['indexOf'](stx_b('0x203'))!==-0x1)d=0xa;if(c['indexOf'](stx_b('0x26'))!==-0x1)d=0x0;if(typeof a[stx_b('0x15c')]!='undefined')d=a['brightness'];this['uniforms']['u7'][stx_b('0xc1')]=0x1+(d-0x1)*this[stx_b('0x1ac')];};STX['SlideEffect'][stx_b('0xf4')][stx_b('0x57')]=function(a){a[stx_b('0xa3')]=this['material'];if(this[stx_b('0xd2')]['u3'][stx_b('0xc1')]==0x0){this[stx_b('0x23c')]['enabled']=this[stx_b('0x1')][stx_b('0xae')]=![];}else{this[stx_b('0x23c')][stx_b('0xae')]=!![];this['blurX_2'][stx_b('0xae')]=!![];this[stx_b('0x23c')][stx_b('0xd2')]['h'][stx_b('0xc1')]=this[stx_b('0xd2')]['u3'][stx_b('0xc1')];this['blurX_2'][stx_b('0xd2')]['h']['value']=this[stx_b('0x23c')][stx_b('0xd2')]['h'][stx_b('0xc1')]*1.4;}};STX['SlideEffect']['prototype'][stx_b('0x133')]=function(a,b){this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a;if(b){this[stx_b('0xd2')]['transitionTo'][stx_b('0xc1')]=b;this[stx_b('0x73')]();}};STX[stx_b('0x1c2')]['prototype'][stx_b('0x1a')]=function(a,b){this[stx_b('0x83')]=a;this[stx_b('0x35')]=typeof a[stx_b('0x35')]!='undefined'?a['blur']:0x1;this[stx_b('0xd2')]['transitionFrom'][stx_b('0xc1')]=a['sliderTextureFrom'];this[stx_b('0xd2')][stx_b('0x193')][stx_b('0xc1')]=a[stx_b('0xd4')];this[stx_b('0x73')]();this[stx_b('0x193')]=a[stx_b('0xd4')];this['pauseVideoCallback']=b;var c=a[stx_b('0xd6')]-a[stx_b('0x1ab')]==0x1||a[stx_b('0x210')];var e=a['transitionEffect'][stx_b('0x1cf')]();var f=1.5,g=0x1,h=0x0,i=0x0;this[stx_b('0x1f0')][stx_b('0x1f2')](function(u){if(e[stx_b('0x232')](u)!==-0x1)a[stx_b('0x88')]=u;});if(e['indexOf'](stx_b('0x203'))!==-0x1||a[stx_b('0x15c')]===stx_b('0x203'))g=0xa;if(e[stx_b('0x232')]('fade')!==-0x1||a[stx_b('0x15c')]==='fade')g=0x0;var j='left';if(j['indexOf'](stx_b('0x243'))!==-0x1)h=-0x1;if(j[stx_b('0x232')](stx_b('0x136'))!==-0x1)h=0x1;if(typeof a[stx_b('0x15c')]==stx_b('0x1f'))g=a[stx_b('0x15c')];var k='Quint';if(e[stx_b('0x232')](stx_b('0x128'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x128')){k=stx_b('0xb6');}if(e[stx_b('0x232')]('fast')!==-0x1||a[stx_b('0xf3')]===stx_b('0x5a')){k='Expo';}if(e[stx_b('0x232')](stx_b('0x117'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x117')){k='Elastic';}var l=stx_b('0x11f')+k;var m=stx_b('0x18a')+k;var n='easeOut'+k;var o=a[stx_b('0xc5')]*(0x1-this[stx_b('0x1ac')]);var p=o*0.5,q=o*0.5;if(this[stx_b('0xd2')]['u5'][stx_b('0xc1')]!=0x0&&this[stx_b('0xd2')]['u5']!=0x1){h=-0x1;i=0x0;l=n;p=o*0.1;q=o*0.9;}if(c){h*=-0x1;i*=-0x1;}var r=this;var s=h!=0x0?this[stx_b('0x35')]*0.01:0x0;var t={'u5':this['uniforms']['u5'][stx_b('0xc1')],'u3':0x0,'u7':this[stx_b('0xd2')]['u7'][stx_b('0xc1')]};var r=this;anime({'targets':t,'u5':h,'u3':[{'value':s,'easing':m,'duration':p},{'value':0x0,'easing':n,'duration':q}],'u7':[{'value':g,'easing':m,'duration':p},{'value':0x1,'easing':n,'duration':q}],'update':function(){for(var u in t){r[stx_b('0xd2')][u][stx_b('0xc1')]=t[u];}},'duration':o,'easing':l,'complete':function(){r[stx_b('0xd2')]['u5']['value']=0x0;r[stx_b('0xd2')]['u3'][stx_b('0xc1')]=0x0;r[stx_b('0xd2')]['u7']['value']=0x1;r[stx_b('0x155')]();r[stx_b('0x217')]();}});};STX[stx_b('0x1c2')]['prototype'][stx_b('0x155')]=function(){this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=this[stx_b('0x193')];this[stx_b('0xd2')][stx_b('0x193')]['value']=this['transitionFrom'];this[stx_b('0x73')]();this[stx_b('0x103')]();this[stx_b('0x20a')]();};STX[stx_b('0xfd')]=function(a,b,c,d){STX[stx_b('0x1d5')][stx_b('0x12a')](this,c);if(STX[stx_b('0x14a')]===undefined)console['error']('STX.SpinEffect\x20relies\x20on\x20STX.SpinShader');var e=STX[stx_b('0x14a')];this['uniforms']=THREE[stx_b('0x1ba')][stx_b('0xc8')](e[stx_b('0xd2')]);this[stx_b('0x140')]=d;this[stx_b('0x1f0')]=['in',stx_b('0x1de')];if(a!==undefined)this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a;this[stx_b('0xa3')]=new THREE[(stx_b('0x11e'))]({'uniforms':this[stx_b('0xd2')],'vertexShader':e['vertexShader'],'fragmentShader':e[stx_b('0x8d')]});this['updateRatio']=function(){if(this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]){var f=this['uniforms'][stx_b('0x240')][stx_b('0xc1')]['image']['width']||this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')][stx_b('0x1ed')]['videoWidth'];var g=this['uniforms']['transitionFrom']['value'][stx_b('0x1ed')]['height']||this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')][stx_b('0x1ed')]['videoHeight'];this[stx_b('0xd2')]['u5']['value']=f/g;this['passes'][stx_b('0x1d3')][stx_b('0xd2')]['u5'][stx_b('0xc1')]=f/g;this[stx_b('0x140')][stx_b('0x214')]['uniforms']['u5'][stx_b('0xc1')]=f/g;}};this[stx_b('0x205')]();};STX[stx_b('0xfd')]['prototype']=Object[stx_b('0xc2')](STX[stx_b('0x1d5')][stx_b('0xf4')]);STX[stx_b('0xfd')][stx_b('0xf4')]['constructor']=STX[stx_b('0xfd')];STX['SpinEffect']['prototype']['progress']=function(a){var b=a[stx_b('0x139')];var c=a[stx_b('0x175')];var d=0x1;this[stx_b('0xd2')]['u3'][stx_b('0xc1')]=-a[stx_b('0x7b')][stx_b('0x177')]/0x2*b;b=Math['abs'](b);if(c['indexOf'](stx_b('0x203'))!==-0x1)d=0xa;if(c[stx_b('0x232')](stx_b('0x26'))!==-0x1)d=0x0;if(typeof a['brightness']!=stx_b('0x200'))d=a['brightness'];if(typeof a[stx_b('0x7b')][stx_b('0xca')]!=stx_b('0x200'))this[stx_b('0xd2')]['u6'][stx_b('0xc1')]=a[stx_b('0x7b')][stx_b('0xca')];if(typeof a['cSlide']['centerY']!='undefined')this[stx_b('0xd2')]['u7']['value']=a[stx_b('0x7b')][stx_b('0x181')];if(typeof a[stx_b('0x7b')]['scale']!=stx_b('0x200'))this[stx_b('0xd2')]['u1'][stx_b('0xc1')]=0x1+(a[stx_b('0x7b')]['scale']-0x1)*b;};STX[stx_b('0xfd')]['prototype']['render']=function(a){a[stx_b('0xa3')]=this[stx_b('0xa3')];if(this['uniforms']['u2'][stx_b('0xc1')]==0x0){this[stx_b('0x140')]['radialBlur1'][stx_b('0xae')]=this['passes'][stx_b('0x214')][stx_b('0xae')]=![];}else{this[stx_b('0x140')][stx_b('0x1d3')][stx_b('0xae')]=this[stx_b('0x140')]['radialBlur2'][stx_b('0xae')]=!![];this[stx_b('0x140')]['radialBlur1']['uniforms']['h'][stx_b('0xc1')]=this['uniforms']['u2'][stx_b('0xc1')];this[stx_b('0x140')][stx_b('0x214')][stx_b('0xd2')]['h'][stx_b('0xc1')]=this['uniforms']['u2'][stx_b('0xc1')]*1.4;this['passes'][stx_b('0x1d3')][stx_b('0xd2')]['cx'][stx_b('0xc1')]=this[stx_b('0xd2')]['u6']['value'];this[stx_b('0x140')][stx_b('0x214')]['uniforms']['cx']['value']=this[stx_b('0xd2')]['u6'][stx_b('0xc1')];this[stx_b('0x140')]['radialBlur1'][stx_b('0xd2')]['cy'][stx_b('0xc1')]=this[stx_b('0xd2')]['u7']['value'];this[stx_b('0x140')][stx_b('0x214')][stx_b('0xd2')]['cy'][stx_b('0xc1')]=this[stx_b('0xd2')]['u7'][stx_b('0xc1')];}};STX[stx_b('0xfd')][stx_b('0xf4')][stx_b('0x133')]=function(a){this[stx_b('0xd2')]['transitionFrom'][stx_b('0xc1')]=a;this[stx_b('0x205')]();};STX[stx_b('0xfd')][stx_b('0xf4')][stx_b('0x1a')]=function(a,b){this[stx_b('0x83')]=a;this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a['sliderTextureFrom'];this['updateRatio']();this[stx_b('0x193')]=a['sliderTextureTo'];this[stx_b('0x103')]=b;if(typeof a[stx_b('0x7b')][stx_b('0xca')]!=stx_b('0x200'))this[stx_b('0xd2')]['u6']['value']=a['cSlide'][stx_b('0xca')];if(typeof a[stx_b('0x7b')][stx_b('0x181')]!='undefined')this['uniforms']['u7'][stx_b('0xc1')]=a[stx_b('0x7b')][stx_b('0x181')];var c=0x1;if(typeof a[stx_b('0x7b')][stx_b('0xb')]!='undefined')c=a[stx_b('0x7b')][stx_b('0xb')];var d=a[stx_b('0xd6')]-a[stx_b('0x1ab')]==0x1;var e=a[stx_b('0x3b')][stx_b('0x1cf')]();var f=-0x168;var g=0x1;var h=0x1;this['directions']['forEach'](function(r){if(e[stx_b('0x232')](r)!==-0x1)a[stx_b('0x88')]=r;});if(e[stx_b('0x232')](stx_b('0xd3'))!==-0x1||a[stx_b('0x177')]===stx_b('0xd3'))f=-0x1c2;if(e[stx_b('0x232')](stx_b('0x1b0'))!==-0x1||a[stx_b('0x177')]==='short')f=-0x10e;if(e[stx_b('0x232')](stx_b('0x203'))!==-0x1||a[stx_b('0x15c')]===stx_b('0x203'))g=0xa;if(e[stx_b('0x232')]('fade')!==-0x1||a[stx_b('0x15c')]===stx_b('0x26'))g=0x0;if(!a[stx_b('0x88')]){var i=STX[stx_b('0x11')][stx_b('0x1bf')](0x0,0x3);a['direction']=this[stx_b('0x1f0')][i];}if(typeof a['distance']==stx_b('0x1f'))f=a[stx_b('0x177')];if(typeof a[stx_b('0x15c')]==stx_b('0x1f'))g=a[stx_b('0x15c')];if(typeof a[stx_b('0x35')]==stx_b('0x1f'))h=a[stx_b('0x35')];var j=stx_b('0x20f');var k='easeOutQuint';if(e['indexOf'](stx_b('0x128'))!==-0x1||a[stx_b('0xf3')]==='slow'){j=stx_b('0x215');k='easeOutSine';}if(e['indexOf'](stx_b('0x5a'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x5a')){j=stx_b('0x9f');k=stx_b('0x1b');}if(e[stx_b('0x232')](stx_b('0x117'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x117')){j=stx_b('0x1aa');k=stx_b('0xc0');}if(e[stx_b('0x232')]('bounce')!==-0x1||a[stx_b('0xf3')]===stx_b('0x15a')){j=stx_b('0x1aa');k='easeOutBounce';}if(a[stx_b('0x88')]==='out')f=-f;if(d)f=-f;var l={'u1':f,'u2':0.2,'u3':g};var m=this;var n={'u1':this['uniforms']['u1'][stx_b('0xc1')],'u2':0x0,'u3':this[stx_b('0xd2')]['u3']['value']};var p=a[stx_b('0x7b')][stx_b('0xc5')];anime({'targets':n,'u1':c,'u2':0.02*h,'u3':f,'change':function(){for(var r in n){m['uniforms'][r][stx_b('0xc1')]=n[r];}},'duration':p/0x2,'easing':j,'complete':function(){m[stx_b('0x155')]();}});var q={'u1':0x1/c,'u2':0.02*h,'u3':-f};anime({'targets':q,'u1':0x1,'u2':0x0,'u3':0x0,'change':function(){for(var r in q){m[stx_b('0xd2')][r][stx_b('0xc1')]=q[r];}},'duration':p/0x2,'delay':p/0x2,'easing':k,'complete':function(){m[stx_b('0xd2')]['u1'][stx_b('0xc1')]=0x1;m[stx_b('0xd2')]['u2'][stx_b('0xc1')]=0x0;m['uniforms']['u3'][stx_b('0xc1')]=0x0;m[stx_b('0x217')]();}});};STX['SpinEffect'][stx_b('0xf4')][stx_b('0x155')]=function(){this[stx_b('0xd2')]['transitionFrom']['value']=this[stx_b('0x193')];this[stx_b('0x205')]();this[stx_b('0x103')]();this[stx_b('0x20a')]();};STX['StretchEffect']=function(a,b,c){STX['Effect']['call'](this,c);if(STX['StretchShader']===undefined)console[stx_b('0x17f')](stx_b('0x4c'));var d=STX[stx_b('0x22c')];this['uniforms']=THREE[stx_b('0x1ba')][stx_b('0xc8')](d[stx_b('0xd2')]);this[stx_b('0x1ac')]=0x0;this['directions']=[stx_b('0x32'),stx_b('0x1ff'),'left','right'];if(a!==undefined)this['uniforms'][stx_b('0x240')]['value']=a;this[stx_b('0xa3')]=new THREE[(stx_b('0x11e'))]({'uniforms':this[stx_b('0xd2')],'vertexShader':d[stx_b('0x204')],'fragmentShader':d[stx_b('0x8d')]});};STX[stx_b('0x161')]['prototype']=Object['create'](STX[stx_b('0x1d5')][stx_b('0xf4')]);STX[stx_b('0x161')][stx_b('0xf4')]['constructor']=STX['StretchEffect'];STX[stx_b('0x161')][stx_b('0xf4')]['render']=function(a){a[stx_b('0xa3')]=this[stx_b('0xa3')];};STX[stx_b('0x161')][stx_b('0xf4')]['resetEffect']=function(a){this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a;};STX[stx_b('0x161')]['prototype'][stx_b('0x139')]=function(a){var b=a[stx_b('0x139')];var c=a['name'];var d=0x1;this[stx_b('0xd2')]['u1']['value']=-b/0x2;this[stx_b('0x1ac')]=Math[stx_b('0x229')](a['progress']);if(c[stx_b('0x232')](stx_b('0x203'))!==-0x1)d=0xa;if(c[stx_b('0x232')](stx_b('0x26'))!==-0x1)d=0x0;if(typeof a['brightness']!=stx_b('0x200'))d=a['brightness'];this[stx_b('0xd2')]['u3'][stx_b('0xc1')]=0x1+(d-0x1)*this[stx_b('0x1ac')];};STX[stx_b('0x161')][stx_b('0xf4')][stx_b('0x1a')]=function(a,b){this[stx_b('0x83')]=a;this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a[stx_b('0xb8')];this[stx_b('0x193')]=a['sliderTextureTo'];this[stx_b('0x103')]=b;var c=a['slideFrom']-a[stx_b('0x1ab')]==0x1;var e=a['transitionEffect'][stx_b('0x1cf')]();var f=2.5,g=0x1,h=0x0,i=0x0;this[stx_b('0x1f0')][stx_b('0x1f2')](function(t){if(e[stx_b('0x232')](t)!==-0x1)a[stx_b('0x88')]=t;});if(e[stx_b('0x232')](stx_b('0xd3'))!==-0x1||a[stx_b('0x177')]===stx_b('0xd3'))f=0x4;if(e[stx_b('0x232')](stx_b('0x1b0'))!==-0x1||a[stx_b('0x177')]===stx_b('0x1b0'))f=1.5;if(e[stx_b('0x232')](stx_b('0x203'))!==-0x1||a[stx_b('0x15c')]==='flash')g=0xa;if(e[stx_b('0x232')](stx_b('0x26'))!==-0x1||a[stx_b('0x15c')]===stx_b('0x26'))g=0x0;if(a['direction']){a['direction']=a[stx_b('0x88')][stx_b('0x231')]('up','top')['replace'](stx_b('0x120'),stx_b('0x1ff'));}else{var j=STX[stx_b('0x11')][stx_b('0x1bf')](0x0,0x3);a[stx_b('0x88')]=this['directions'][j];}if(a[stx_b('0x88')]==='top')i=-0x1;if(a['direction']==='bottom')i=0x1;if(a[stx_b('0x88')]===stx_b('0x243'))h=0x1;if(a[stx_b('0x88')]===stx_b('0x136'))h=-0x1;if(typeof a['distance']=='number')f=a[stx_b('0x177')];if(typeof a['brightness']==stx_b('0x1f'))g=a[stx_b('0x15c')];var k=stx_b('0x157');if(e[stx_b('0x232')](stx_b('0x128'))!==-0x1||a['easing']===stx_b('0x128')){k=stx_b('0x225');}if(e[stx_b('0x232')](stx_b('0x5a'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x5a')){k=stx_b('0xc3');}if(e[stx_b('0x232')](stx_b('0x117'))!==-0x1||a[stx_b('0xf3')]==='elastic'){k='Elastic';}var l='easeIn'+k;var m=stx_b('0x11f')+k;var n=a['transitionDuration']*(0x1-this['progressVal']);var o=n*0.5,p=n*0.5;h*=f;i*=f;if(c){h*=-0x1;i*=-0x1;}var q=this;var r={'u1':this[stx_b('0xd2')]['u1']['value'],'u2':this['uniforms']['u2'][stx_b('0xc1')],'u3':this['uniforms']['u3'][stx_b('0xc1')]};anime({'targets':r,'u1':h,'u2':i,'u3':g,'change':function(){for(var t in r){q[stx_b('0xd2')][t][stx_b('0xc1')]=r[t];}},'duration':o,'easing':l,'complete':function(){q[stx_b('0x155')]();}});var s={'u1':-h,'u2':-i,'u3':g};anime({'targets':s,'u1':0x0,'u2':0x0,'u3':0x1,'change':function(){for(var t in s){q[stx_b('0xd2')][t][stx_b('0xc1')]=s[t];}},'duration':p,'delay':o,'easing':m,'complete':function(){q[stx_b('0xd2')]['u1'][stx_b('0xc1')]=0x0;q[stx_b('0xd2')]['u2']['value']=0x0;q['uniforms']['u3'][stx_b('0xc1')]=0x1;q['animationComplete']();}});};STX[stx_b('0x161')][stx_b('0xf4')]['switchTexture']=function(){this['uniforms'][stx_b('0x240')][stx_b('0xc1')]=this['transitionTo'];this[stx_b('0x103')]();this['switchTextureComplete']();};STX[stx_b('0xd')]=function(a,b,c){STX[stx_b('0x1d5')][stx_b('0x12a')](this,c);if(STX[stx_b('0x17b')]===undefined)console[stx_b('0x17f')]('STX.TwirlEffect\x20relies\x20on\x20STX.TwirlShader');var d=STX[stx_b('0x17b')];this['uniforms']=THREE[stx_b('0x1ba')][stx_b('0xc8')](d['uniforms']);this['directions']=[stx_b('0x243'),stx_b('0x136')];this[stx_b('0x1ac')]=0x0;if(a!==undefined)this['uniforms']['transitionFrom'][stx_b('0xc1')]=a;this[stx_b('0xa3')]=new THREE[(stx_b('0x11e'))]({'uniforms':this[stx_b('0xd2')],'vertexShader':d['vertexShader'],'fragmentShader':d['fragmentShader']});};STX[stx_b('0xd')][stx_b('0xf4')]=Object[stx_b('0xc2')](STX['Effect'][stx_b('0xf4')]);STX[stx_b('0xd')][stx_b('0xf4')][stx_b('0xef')]=STX['TwirlEffect'];STX['TwirlEffect'][stx_b('0xf4')][stx_b('0x57')]=function(a){a['material']=this[stx_b('0xa3')];};STX['TwirlEffect'][stx_b('0xf4')]['resetEffect']=function(a){this[stx_b('0xd2')]['transitionFrom'][stx_b('0xc1')]=a;};STX[stx_b('0xd')][stx_b('0xf4')][stx_b('0x139')]=function(a){var b=a[stx_b('0x139')];var c=a['name'];var d=0x1;this[stx_b('0xd2')]['u1'][stx_b('0xc1')]=-b;this[stx_b('0x1ac')]=Math[stx_b('0x229')](a[stx_b('0x139')]);if(c[stx_b('0x232')](stx_b('0x203'))!==-0x1)d=0xa;if(c[stx_b('0x232')](stx_b('0x26'))!==-0x1)d=0x0;if(typeof a['brightness']!=stx_b('0x200'))d=a[stx_b('0x15c')];this[stx_b('0xd2')]['u7'][stx_b('0xc1')]=0x1+(d-0x1)*this[stx_b('0x1ac')];};STX[stx_b('0xd')][stx_b('0xf4')][stx_b('0x1a')]=function(a,b){this[stx_b('0x83')]=a;this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a[stx_b('0xb8')];this[stx_b('0x193')]=a['sliderTextureTo'];this['pauseVideoCallback']=b;var c=a[stx_b('0xd6')]-a[stx_b('0x1ab')]==0x1;var e=a[stx_b('0x3b')][stx_b('0x1cf')]();var f=0x2+Math[stx_b('0x11b')]()*0x4;var g=0x1;this[stx_b('0x1f0')][stx_b('0x1f2')](function(t){if(e[stx_b('0x232')](t)!==-0x1)a[stx_b('0x88')]=t;});if(e['indexOf']('long')!==-0x1||a['distance']==='long')f=0x5+Math['random']()*0x2;if(e[stx_b('0x232')](stx_b('0x1b0'))!==-0x1||a[stx_b('0x177')]==='short')f=0x3+Math['random']()*0x1;if(e[stx_b('0x232')](stx_b('0x203'))!==-0x1||a[stx_b('0x15c')]==='flash')g=0xa;if(e['indexOf'](stx_b('0x26'))!==-0x1||a[stx_b('0x15c')]===stx_b('0x26'))g=0x0;if(a[stx_b('0x88')]==stx_b('0x11b')){var h=STX[stx_b('0x11')][stx_b('0x1bf')](0x0,0x1);a[stx_b('0x88')]=this[stx_b('0x1f0')][h];}else if(!a[stx_b('0x88')]){a[stx_b('0x88')]='left';}if(typeof a[stx_b('0x177')]==stx_b('0x1f'))f=a[stx_b('0x177')];if(typeof a[stx_b('0x15c')]=='number')g=a[stx_b('0x15c')];var i=stx_b('0x157');if(e[stx_b('0x232')](stx_b('0x128'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x128')){i='Quart';}if(e[stx_b('0x232')](stx_b('0x5a'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x5a')){i=stx_b('0xc3');}if(e[stx_b('0x232')]('elastic')!==-0x1||a[stx_b('0xf3')]===stx_b('0x117')){i=stx_b('0x12');}var j=stx_b('0x18a')+i;var k=stx_b('0x11f')+i;var l=a[stx_b('0xc5')]*(0x1-this[stx_b('0x1ac')]);var m=l*0.5,n=l*0.5;if(a[stx_b('0x88')]===stx_b('0x136'))f=-f;if(this['uniforms']['u1'][stx_b('0xc1')]!=0x0){f=Math[stx_b('0x229')](f);}if(c)f=-f;var p={'u1':f,'u4':0x2+Math['random']()*0x4,'u7':g,'easing1':j,'easing2':k};var q=this;var r={'u1':this[stx_b('0xd2')]['u1'][stx_b('0xc1')],'u4':0x0,'u7':this[stx_b('0xd2')]['u7'][stx_b('0xc1')]};anime({'targets':r,'u1':p['u1'],'u4':p['u4'],'u7':p['u7'],'change':function(){for(var t in r){q['uniforms'][t][stx_b('0xc1')]=r[t];}},'duration':m,'easing':j,'complete':function(){q['switchTexture']();}});var s={'u1':-p['u1'],'u4':p['u4'],'u7':p['u7']};anime({'targets':s,'u1':0x0,'u4':0x0,'u7':0x1,'change':function(){for(var t in s){q['uniforms'][t][stx_b('0xc1')]=s[t];}},'duration':n,'delay':m,'easing':k,'complete':function(){q['animationComplete']();}});};STX[stx_b('0xd')]['prototype'][stx_b('0x155')]=function(){this[stx_b('0xd2')][stx_b('0x240')]['value']=this[stx_b('0x193')];this[stx_b('0x103')]();this[stx_b('0x20a')]();};STX[stx_b('0x127')]=function(a,b,c,d){STX['Effect'][stx_b('0x12a')](this,c);this[stx_b('0x23c')]=d[stx_b('0x1f7')];this[stx_b('0x1')]=d[stx_b('0x18f')];this[stx_b('0xb2')]=d['vBlur1'];this[stx_b('0x17a')]=d['vBlur2'];this[stx_b('0x25')]=d['fisheyePass'];if(STX[stx_b('0x13d')]===undefined)console['error'](stx_b('0x15b'));var e=STX[stx_b('0x13d')];this[stx_b('0xd2')]=THREE['UniformsUtils']['clone'](e[stx_b('0xd2')]);this[stx_b('0x35')]=0x1;this[stx_b('0x1ac')]=0x0;this['directions']=[stx_b('0x32'),'bottom',stx_b('0x243'),stx_b('0x136')];if(a!==undefined)this[stx_b('0xd2')][stx_b('0x240')]['value']=a;this[stx_b('0xa3')]=new THREE[(stx_b('0x11e'))]({'uniforms':this[stx_b('0xd2')],'vertexShader':e[stx_b('0x204')],'fragmentShader':e['fragmentShader']});};STX['WarpEffect'][stx_b('0xf4')]=Object[stx_b('0xc2')](STX['Effect'][stx_b('0xf4')]);STX[stx_b('0x127')][stx_b('0xf4')][stx_b('0xef')]=STX[stx_b('0x127')];STX[stx_b('0x127')][stx_b('0xf4')][stx_b('0x57')]=function(a){a[stx_b('0xa3')]=this[stx_b('0xa3')];if(this['uniforms']['u3']['value']==0x0){this['blurX_1'][stx_b('0xae')]=this[stx_b('0x1')][stx_b('0xae')]=![];}else{this['blurX_1'][stx_b('0xae')]=this['blurX_2']['enabled']=!![];this[stx_b('0x23c')]['uniforms']['h'][stx_b('0xc1')]=this['uniforms']['u3']['value'];this[stx_b('0x1')]['uniforms']['h'][stx_b('0xc1')]=this[stx_b('0x23c')]['uniforms']['h'][stx_b('0xc1')]*1.4;}if(this[stx_b('0xd2')]['u4']['value']==0x0){this[stx_b('0xb2')]['enabled']=this[stx_b('0x17a')][stx_b('0xae')]=![];}else{this[stx_b('0xb2')]['enabled']=!![];this[stx_b('0xb2')][stx_b('0xae')]=this[stx_b('0x17a')]['enabled']=!![];this['blurY_1']['uniforms']['h'][stx_b('0xc1')]=this[stx_b('0xd2')]['u4'][stx_b('0xc1')];this[stx_b('0x17a')][stx_b('0xd2')]['h'][stx_b('0xc1')]=this[stx_b('0xb2')][stx_b('0xd2')]['h'][stx_b('0xc1')]*1.4;}if(this['uniforms']['u1'][stx_b('0xc1')]==0x0){this[stx_b('0x25')][stx_b('0xae')]=![];}else{this['fisheye'][stx_b('0xae')]=!![];this[stx_b('0x25')]['uniforms']['f'][stx_b('0xc1')]=this[stx_b('0xd2')]['u1'][stx_b('0xc1')];this[stx_b('0x25')][stx_b('0xd2')]['u5'][stx_b('0xc1')]=this[stx_b('0xd2')]['u5'][stx_b('0xc1')];this['fisheye'][stx_b('0xd2')]['u6'][stx_b('0xc1')]=this['uniforms']['u6']['value'];}};STX[stx_b('0x127')][stx_b('0xf4')][stx_b('0x133')]=function(a){this['uniforms'][stx_b('0x240')]['value']=a;};STX[stx_b('0x127')]['prototype'][stx_b('0x139')]=function(a){var b=a[stx_b('0x139')];var c=a[stx_b('0x175')];var d=0x1;this['uniforms']['u5'][stx_b('0xc1')]=b;this[stx_b('0xd2')]['u1'][stx_b('0xc1')]=-0.1*Math[stx_b('0x229')](b);this[stx_b('0x1ac')]=Math[stx_b('0x229')](a[stx_b('0x139')]);if(c[stx_b('0x232')](stx_b('0x203'))!==-0x1)d=0xa;if(c['indexOf']('fade')!==-0x1)d=0x0;if(typeof a['brightness']!=stx_b('0x200'))d=a[stx_b('0x15c')];this[stx_b('0xd2')]['u7']['value']=0x1+(d-0x1)*this[stx_b('0x1ac')];};STX[stx_b('0x127')]['prototype'][stx_b('0x1a')]=function(a,b){this[stx_b('0x83')]=a;this[stx_b('0x35')]=typeof a[stx_b('0x35')]!='undefined'?a[stx_b('0x35')]:0x1;this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a[stx_b('0xb8')];this[stx_b('0x193')]=a[stx_b('0xd4')];this[stx_b('0x103')]=b;var c=a['slideFrom']-a['slideTo']==0x1;var e=a[stx_b('0x3b')][stx_b('0x1cf')]();var f=0x2,g=0x1,h=0x0,i=0x0;this[stx_b('0x1f0')][stx_b('0x1f2')](function(z){if(e[stx_b('0x232')](z)!==-0x1)a[stx_b('0x88')]=z;});if(e['indexOf'](stx_b('0xd3'))!==-0x1||a[stx_b('0x177')]===stx_b('0xd3'))f=2.5;if(e[stx_b('0x232')]('short')!==-0x1||a['distance']===stx_b('0x1b0'))f=1.5;if(e[stx_b('0x232')](stx_b('0x203'))!==-0x1||a[stx_b('0x15c')]===stx_b('0x203'))g=0xa;if(e[stx_b('0x232')](stx_b('0x26'))!==-0x1||a['brightness']==='fade')g=0x0;if(a['direction']){a[stx_b('0x88')]=a[stx_b('0x88')][stx_b('0x231')]('up',stx_b('0x32'))[stx_b('0x231')](stx_b('0x120'),stx_b('0x1ff'));if(a[stx_b('0x88')]==stx_b('0x11b')){var j=STX[stx_b('0x11')][stx_b('0x1bf')](0x0,0x3);a[stx_b('0x88')]=this[stx_b('0x1f0')][j];}}else{a['direction']=stx_b('0x243');}var k=a[stx_b('0x88')][stx_b('0x1cf')]();if(k[stx_b('0x232')](stx_b('0x32'))!==-0x1)i=0x1;if(k[stx_b('0x232')](stx_b('0x1ff'))!==-0x1)i=-0x1;if(k[stx_b('0x232')](stx_b('0x243'))!==-0x1)h=-0x1;if(k[stx_b('0x232')]('right')!==-0x1)h=0x1;if(this[stx_b('0xd2')]['u5'][stx_b('0xc1')]!=0x0){h=-0x1;i=0x0;}if(typeof a[stx_b('0x177')]==stx_b('0x1f'))f=a[stx_b('0x177')];if(typeof a[stx_b('0x15c')]=='number')g=a['brightness'];var l='Quint';if(e[stx_b('0x232')](stx_b('0x128'))!==-0x1||a[stx_b('0xf3')]==='slow'){l='Cubic';}if(e[stx_b('0x232')](stx_b('0x5a'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x5a')){l=stx_b('0xc3');}if(e[stx_b('0x232')](stx_b('0x117'))!==-0x1||a['easing']==='elastic'){l=stx_b('0x12');}var m=stx_b('0x18a')+l;var n=stx_b('0x11f')+l;var o=a[stx_b('0xc5')]*(0x1-this[stx_b('0x1ac')]);var p=o*0.5,q=o*0.5;h*=f;i*=f;if(c){h*=-0x1;i*=-0x1;}var r={'u1':this[stx_b('0xd2')]['u1'][stx_b('0xc1')],'u3':0x0,'u4':0x0,'u5':this[stx_b('0xd2')]['u5'][stx_b('0xc1')],'u6':0x0,'u7':this[stx_b('0xd2')]['u7']['value']};var s=0x0;if(h!=0x0){s=-0.1;}if(i!=0x0){s=-0.1;}var t=this;var u=h!=0x0?this[stx_b('0x35')]*0.01:0x0;var v=i!=0x0?this[stx_b('0x35')]*0.01:0x0;anime({'targets':r,'u1':s,'u3':u,'u4':v,'u5':h,'u6':i,'u7':g,'change':function(){for(var z in r){t[stx_b('0xd2')][z][stx_b('0xc1')]=r[z];}},'duration':p,'easing':m,'complete':function(){t[stx_b('0x155')]();}});var w={'u1':s,'u3':u,'u4':v,'u5':-h,'u6':-i,'u7':g};anime({'targets':w,'u1':0x0,'u3':0x0,'u4':0x0,'u5':0x0,'u6':0x0,'u7':0x1,'change':function(){for(var z in w){t[stx_b('0xd2')][z][stx_b('0xc1')]=w[z];}},'duration':q,'delay':p,'easing':n,'complete':function(){t['uniforms']['u1'][stx_b('0xc1')]=0x0;t[stx_b('0xd2')]['u3'][stx_b('0xc1')]=0x0;t[stx_b('0xd2')]['u4']['value']=0x0;t[stx_b('0xd2')]['u5'][stx_b('0xc1')]=0x0;t[stx_b('0xd2')]['u6'][stx_b('0xc1')]=0x0;t[stx_b('0x217')]();}});};STX[stx_b('0x127')][stx_b('0xf4')][stx_b('0x155')]=function(){this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=this[stx_b('0x193')];this[stx_b('0x103')]();this[stx_b('0x20a')]();};STX['ZoomEffect']=function(a,b,c,d){STX['Effect'][stx_b('0x12a')](this,c);this[stx_b('0x4')]=d[stx_b('0x30')];this['blur_2']=d[stx_b('0x104')];this[stx_b('0xcb')]=d[stx_b('0x167')];this[stx_b('0x25')]=d[stx_b('0x109')];this['progressVal']=0x0;this[stx_b('0x35')]=0x1;if(STX[stx_b('0x121')]===undefined)console[stx_b('0x17f')](stx_b('0xde'));var e=STX[stx_b('0x121')];this[stx_b('0xd2')]=THREE[stx_b('0x1ba')][stx_b('0xc8')](e['uniforms']);this['directions']=['in','out'];if(a!==undefined)this[stx_b('0xd2')]['transitionFrom'][stx_b('0xc1')]=a;this[stx_b('0xa3')]=new THREE[(stx_b('0x11e'))]({'uniforms':this['uniforms'],'vertexShader':e[stx_b('0x204')],'fragmentShader':e[stx_b('0x8d')]});};STX[stx_b('0x150')][stx_b('0xf4')]=Object[stx_b('0xc2')](STX[stx_b('0x1d5')][stx_b('0xf4')]);STX['ZoomEffect'][stx_b('0xf4')][stx_b('0xef')]=STX[stx_b('0x150')];STX[stx_b('0x150')][stx_b('0xf4')][stx_b('0x57')]=function(a){a[stx_b('0xa3')]=this[stx_b('0xa3')];if(this[stx_b('0xd2')]['u1'][stx_b('0xc1')]==0x1){this[stx_b('0xcb')][stx_b('0xae')]=![];}else{this[stx_b('0xcb')][stx_b('0xae')]=!![];this[stx_b('0xcb')]['uniforms']['sx']['value']=this[stx_b('0xd2')]['u1'][stx_b('0xc1')];this[stx_b('0xcb')]['uniforms']['sy'][stx_b('0xc1')]=this[stx_b('0xd2')]['u1'][stx_b('0xc1')];}if(this[stx_b('0xd2')]['u2'][stx_b('0xc1')]==0x0){this[stx_b('0x4')]['enabled']=this['blur_2'][stx_b('0xae')]=![];}else{this['blur_1']['enabled']=this[stx_b('0xf1')][stx_b('0xae')]=!![];this[stx_b('0x4')]['uniforms']['h'][stx_b('0xc1')]=this[stx_b('0xd2')]['u2'][stx_b('0xc1')];this['blur_2'][stx_b('0xd2')]['h'][stx_b('0xc1')]=this[stx_b('0x4')][stx_b('0xd2')]['h'][stx_b('0xc1')]*1.4;}};STX[stx_b('0x150')][stx_b('0xf4')][stx_b('0x133')]=function(a){this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a;};STX[stx_b('0x150')][stx_b('0xf4')]['progress']=function(a){var b=a[stx_b('0x139')];var c=a[stx_b('0x175')];var d=0x1;this[stx_b('0xd2')]['u1'][stx_b('0xc1')]=0x1-b/0x2;this[stx_b('0x1ac')]=Math[stx_b('0x229')](a[stx_b('0x139')]);if(c['indexOf']('flash')!==-0x1)d=0xa;if(c['indexOf'](stx_b('0x26'))!==-0x1)d=0x0;if(typeof a[stx_b('0x15c')]!=stx_b('0x200'))d=a['brightness'];this['uniforms']['u3'][stx_b('0xc1')]=0x1+(d-0x1)*this[stx_b('0x1ac')];};STX[stx_b('0x150')][stx_b('0xf4')][stx_b('0x1a')]=function(a,b){this['options']=a;this[stx_b('0x35')]=typeof a[stx_b('0x35')]!='undefined'?a[stx_b('0x35')]:0x1;this[stx_b('0xd2')][stx_b('0x240')][stx_b('0xc1')]=a[stx_b('0xb8')];this[stx_b('0x193')]=a[stx_b('0xd4')];this['pauseVideoCallback']=b;var c=a[stx_b('0xd6')]-a[stx_b('0x1ab')]==0x1;var e=a[stx_b('0x3b')]['toLowerCase']();var f=0x2,g=0x1,h=0x1;this['directions'][stx_b('0x1f2')](function(t){if(e[stx_b('0x232')](t)!==-0x1)a[stx_b('0x88')]=t;});if(e[stx_b('0x232')](stx_b('0xd3'))!==-0x1||a[stx_b('0x177')]===stx_b('0xd3'))f=0x3;if(e[stx_b('0x232')](stx_b('0x1b0'))!==-0x1||a[stx_b('0x177')]===stx_b('0x1b0'))f=0x1;if(e[stx_b('0x232')](stx_b('0x203'))!==-0x1||a['brightness']==='flash')g=0xa;if(e[stx_b('0x232')]('fade')!==-0x1||a[stx_b('0x15c')]==='fade')g=0x0;if(a[stx_b('0x88')]=='random'){var i=STX[stx_b('0x11')][stx_b('0x1bf')](0x0,0x1);a[stx_b('0x88')]=this[stx_b('0x1f0')][i];}else if(!a[stx_b('0x88')]){a['direction']='in';}if(typeof a['distance']==stx_b('0x1f'))f=a[stx_b('0x177')];if(typeof a['brightness']==stx_b('0x1f'))g=a['brightness'];var j='Quint';if(e['indexOf'](stx_b('0x128'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x128')){j=stx_b('0x225');}if(e[stx_b('0x232')](stx_b('0x5a'))!==-0x1||a[stx_b('0xf3')]===stx_b('0x5a')){j=stx_b('0xc3');}if(e[stx_b('0x232')]('elastic')!==-0x1||a[stx_b('0xf3')]===stx_b('0x117')){j=stx_b('0x12');}var k=stx_b('0x18a')+j;var l='easeOut'+j;var m=a[stx_b('0xc5')]*(0x1-this[stx_b('0x1ac')]);var n=m*0.5,o=m*0.5;if(a['direction']==='out')f=0x1/f;if(this['uniforms']['u1'][stx_b('0xc1')]!=0x1){f=Math[stx_b('0x229')](f);}if(c)f=0x1/f;var p=this;var q={'u1':this['uniforms']['u1'][stx_b('0xc1')],'u2':0x0,'u3':this['uniforms']['u3'][stx_b('0xc1')]};var r=this[stx_b('0x35')]*0.02;anime({'targets':q,'u1':f,'u2':r,'u3':g,'change':function(){for(var t in q){p[stx_b('0xd2')][t][stx_b('0xc1')]=q[t];}},'duration':n,'easing':k,'complete':function(){p['switchTexture']();}});var s={'u1':0x1/f,'u2':r,'u3':g};anime({'targets':s,'u1':0x1,'u2':0x0,'u3':0x1,'change':function(){for(var t in s){p[stx_b('0xd2')][t]['value']=s[t];}},'duration':o,'delay':n,'easing':l,'complete':function(){p[stx_b('0xd2')]['u1'][stx_b('0xc1')]=0x1;p[stx_b('0xd2')]['u2']['value']=0x0;p['uniforms']['u3'][stx_b('0xc1')]=0x1;p[stx_b('0x217')]();}});};STX['ZoomEffect'][stx_b('0xf4')][stx_b('0x155')]=function(){this[stx_b('0xd2')][stx_b('0x240')]['value']=this[stx_b('0x193')];this['pauseVideoCallback']();this[stx_b('0x20a')]();};

STX.Transition = function(options) {
    var self = this;
    self.options = options;
    self.ev = self.options.ev;
    this.iOS = STX.Utils.iOS();
    var width = self.options.camera.width;
    var height = self.options.camera.height;

    self.renderEnabled = true;

    self.ev.on("animationComplete", function() {
        self.renderOnce();

        if (!options.layerStarOnTransitionStart) self.layers.animateLayer(self.currentSlideIndex, "startAnimation");
    });
    self.ev.on("updateRendererStatus", function(event, renderingStatus) {
        if (self.slides[self.currentSlideIndex].mediaType === "IMAGE") {
            self.updateRendering(renderingStatus);
        }
    });
    self.ev.on("onMuteButtonUpdate", function(event, muted) {
        self.updateVideoSlidesWithMuteStatus(muted);
    });
    self.ev.on("onPauseButtonUpdate", function(event, paused) {
        self.updateVideoSlidesWithPauseStatus(paused);
    });

    document.addEventListener("visibilitychange", function() {
        if (document.visibilityState == "visible" && self.effectHandler) {
            self.effectHandler.render();
            self.composer.render(self.scene, self.camera);
        }
    });

    self.container = self.options.container;
    self.renderer = new THREE.WebGLRenderer({ antialias: false, alpha: true, preserveDrawingBuffer: false });
    self.renderer.domElement.style.transformOrigin = "0 0";
    self.renderer.setPixelRatio(window.devicePixelRatio);
    self.renderer.setSize(width, height);

    self.transform = self.renderer.domElement.style.transform || self.renderer.domElement.style.webkitTransform;

    self.isRendering = true;
    self.initRendering = true;
    self.container.appendChild(self.renderer.domElement);

    if (options.parallax) {
        self.renderer.domElement.classList.add("stx-parallax");
        self.renderer.domElement.dataset.stxParallax = options.parallax;
    }

    self.slides = {};
    self.slides = self.options.slidesToLoad;
    self.currentSlideIndex = self.options.initialSlide;
    self.previousSlideIndex = self.currentSlideIndex;

    self.sliderPaused = false;

    self.camera = new THREE.OrthographicCamera(-1, 1, 1, -1, -1, 1, 1000);
    self.scene = new THREE.Scene();

    self.composer = new THREE.EffectComposer(self.renderer);
    self.composer.setSize(width, height);

    var renderPass = new THREE.RenderPass(self.scene, self.camera);
    self.composer.addPass(renderPass);



    self.hBlur1 = new THREE.ShaderPass(THREE.HorizontalBlurShader);
    self.composer.addPass(self.hBlur1);
    self.hBlur1.enabled = false;

    self.hBlur2 = new THREE.ShaderPass(THREE.HorizontalBlurShader);
    self.composer.addPass(self.hBlur2);
    self.hBlur2.enabled = false;

    self.vblur1 = new THREE.ShaderPass(THREE.VerticalBlurShader);
    self.composer.addPass(self.vblur1);
    self.vblur1.enabled = false;

    self.vblur2 = new THREE.ShaderPass(THREE.VerticalBlurShader);
    self.composer.addPass(self.vblur2);
    self.vblur2.enabled = false;

    self.fisheyePass = new THREE.ShaderPass(THREE.FisheyeShader);
    self.composer.addPass(self.fisheyePass);
    self.fisheyePass.enabled = false;

    self.transformPass = new THREE.ShaderPass(THREE.TransformShader);
    self.composer.addPass(self.transformPass);
    self.transformPass.enabled = false;

    self.zoomBlur1 = new THREE.ShaderPass(THREE.ZoomBlurShader);
    self.composer.addPass(self.zoomBlur1);
    self.zoomBlur1.enabled = false;

    self.zoomBlur2 = new THREE.ShaderPass(THREE.ZoomBlurShader);
    self.composer.addPass(self.zoomBlur2);
    self.zoomBlur2.enabled = false;

    self.radialBlur1 = new THREE.ShaderPass(THREE.RadialBlurShader);
    self.composer.addPass(self.radialBlur1);
    self.radialBlur1.enabled = false;

    self.radialBlur2 = new THREE.ShaderPass(THREE.RadialBlurShader);
    self.composer.addPass(self.radialBlur2);
    self.radialBlur2.enabled = false;

    self.passes = {
        hBlur1: self.hBlur1,
        hBlur2: self.hBlur2,
        vBlur1: self.vblur1,
        vBlur2: self.vblur2,
        fisheyePass: self.fisheyePass,
        transformPass: self.transformPass,
        zoomBlur1: self.zoomBlur1,
        zoomBlur2: self.zoomBlur2,
        radialBlur1: self.radialBlur1,
        radialBlur2: self.radialBlur2
    };


    self.camera.position.z = 1;

    self.layers = options.layers;

    self.getTexture = function(textureId, callback) {
        if (self.slides[textureId].src.match(location.host)) self.slides[textureId].src = self.slides[textureId].src.replace("http:", location.protocol).replace("https:", location.protocol);

        var slideMediaType = self.slides[textureId].mediaType;

        switch (slideMediaType) {
            case "IMAGE":
                if (!self.slides[textureId].texture) {
                    self.checkForVideoSlideAndPause(self.previousSlideIndex);
                    self.loader.load(
                        self.slides[textureId].src,
                        function(texture) {
                            self.bufferSlideTexture(texture, textureId, callback);
                        },
                        undefined,
                        function(err) {
                            console.error("ERROR on loading texture" + err);
                        }
                    );
                } else {
                    self.bufferSlideTexture(self.slides[textureId].texture, textureId, callback);
                }
                break;

            case "VIDEO":
                if (!self.slides[textureId].videoObject) {
                    for (var index = 0; index < self.slides.length; index++) {
                        if (self.slides[index].videoObject && !self.slides[textureId].videoObject && index !== textureId && self.slides[index].src === self.slides[textureId].src) {
                            self.slides[textureId].videoObject = self.slides[index].videoObject;
                        }
                    }
                }

                if (!self.slides[textureId].videoObject) {
                    self.slides[textureId].videoObject = new STX.VideoSlideObject({
                        height: options.camera.height,
                        width: options.camera.width,
                        src: self.slides[textureId].src
                    });
                }

                var texture = self.slides[textureId].videoObject.texture;

                if (self.slides[textureId].videoObject.video.readyState < 3) {
                    if (textureId === self.currentSlideIndex) {
                        self.checkForVideoSlideAndPause(self.previousSlideIndex);
                    }
                    self.slides[textureId].videoObject.video.onloadeddata = function() {
                        self.bufferSlideTexture(texture, textureId, callback);
                    };
                } else {
                    self.bufferSlideTexture(texture, textureId, callback);
                }

                break;

            case "NOT_SUPPORTED":
                console.log("Slide media format is not supported, please try with other media file format.");
        }
    };

    self.bufferSlideTexture = function(texture, textureId, callback) {
        var alphaMap = self.slides[textureId].alphaMap;

        if (alphaMap && !texture.alphaMap) {
            self.loader.load(
                alphaMap,
                function(alphaMapTexture) {
                    alphaMapTexture.minFilter = THREE.LinearFilter;
                    alphaMapTexture.magFilter = THREE.LinearFilter;
                    texture.alphaMap = alphaMapTexture;
                    self.bufferSlideTexture(texture, textureId, callback);
                },
                undefined,
                function(err) {
                    console.error("ERROR on loading texture" + err);
                }
            );
            return;
        }

        texture.minFilter = THREE.LinearFilter;
        texture.magFilter = THREE.LinearFilter;
        texture.format = THREE.RGBAFormat;
        self.slides[textureId].texture = texture;
        if (callback) {
            callback();
        }
    };

    self.checkForLoadNextTexture = function(textureId) {
        if (self.slides.length === textureId) {
            textureId = 0;
        }
        if (!self.slides[textureId].texture && self.slides.length >= textureId + 1) {
            self.layers.loadLayer(textureId, function() {
                self.getTexture(textureId);
            });
        }
    };

    self.checkForVideoSlideAndPlay = function(slideIndex) {
        if (self.slides[slideIndex].videoObject && !self.sliderPaused) {
            if (self.options.resetVideos) self.slides[slideIndex].videoObject.video.currentTime = 0;
            if (self.options.videoAutoplay) self.slides[slideIndex].videoObject.video.play();
        }
    };

    self.checkForVideoSlideAndPause = function(slideIndex) {
        if (self.slides[slideIndex].videoObject) {
            self.slides[slideIndex].videoObject.video.pause();
        }
    };

    self.checkForVideoSlideToShowMuteButton = function(slideIndex) {
        if (self.slides[slideIndex].videoObject) {
            self.ev.trigger("showVideoButtons");
        } else {
            self.ev.trigger("hideVideoButtons");
        }
    };

    self.updateVideoSlidesWithMuteStatus = function(muted) {
        self.slides.forEach(function(slide) {
            if (slide.videoObject) {
                slide.videoObject.video.muted = muted;
            }
        });
    };

    self.updateVideoSlidesWithPauseStatus = function(paused) {
        if (paused) {
            self.slides.forEach(function(slide) {
                if (slide.videoObject) {
                    slide.videoObject.video.pause();
                    self.sliderPaused = true;
                }
            });
        } else {
            if (self.slides[self.currentSlideIndex].videoObject) {
                self.slides[self.currentSlideIndex].videoObject.video.play();
                self.sliderPaused = false;
            }
        }
    };

    self.render = function render() {
        requestAnimationFrame(render);
        self.effectHandler.render();
        if (self.renderEnabled || self.needsUpdate) {
            if (self.rendererSize != self.resizeInfo) {
                self.rendererSize = self.resizeInfo;

                self.renderer.setSize(self.resizeInfo.width, self.resizeInfo.height);

                if (self.resizeInfo.height > 400) self.composer.setSize((400 * self.resizeInfo.width) / self.resizeInfo.height, 400);
                else self.composer.setSize(self.resizeInfo.width, self.resizeInfo.height);
            }

            self.needsUpdate = false;


            self.composer.render(self.scene, self.camera);
        }
    };

    self.reloadTransition = function(options) {
        var initialSlide = options.initialSlide;
        var initialEffect = options.initialEffect;

        self.options = options;
        self.slide.geometry.dispose();
        self.slide.geometry = new THREE.PlaneGeometry(2, 2);
        self.slides = {};
        self.slides = options.slidesToLoad;
        self.currentSlideIndex = self.options.initialSlide;
        self.previousSlideIndex = self.currentSlideIndex;

        self.ev.trigger("showLoading");
        self.updateRendering(false);

        var slideMediaType = self.slides[initialSlide].mediaType;
        var src = self.slides[initialSlide].src;

        switch (slideMediaType) {
            case "IMAGE":
                self.loader.load(
                    src,
                    function(texture) {
                        setupTransitionAfterReload(texture, initialSlide, initialEffect);
                    },
                    undefined,
                    function(err) {
                        console.error("ERROR on loading texture" + err);
                    }
                );
                break;

            case "VIDEO":
                var videoSlideObject = new STX.VideoSlideObject({
                    height: options.camera.height,
                    width: options.camera.width,
                    src: src
                });
                self.slides[initialSlide].videoObject = videoSlideObject;
                self.slides[initialSlide].videoObject.video.onloadeddata = function() {
                    setupTransitionAfterReload(self.slides[initialSlide].videoObject.texture, initialSlide, initialEffect);
                };

                break;

            case "NOT_SUPPORTED":
                console.log("Slide media format is not supported, please try with other media file format.");
        }

        function setupTransitionAfterReload(texture, initialSlide, initialEffect) {
            self.bufferSlideTexture(texture, initialSlide);
            self.checkForLoadNextTexture(initialSlide + 1);

            self.effectHandler.resetEffectHandler();
            self.effectHandler.addEffect({
                transitionEffect: initialEffect,
                sliderTextureFrom: self.slides[initialSlide].texture,
                passes: self.passes
            });

            self.layers.loadLayer(initialSlide, function() {
                self.ev.trigger("initSwiper");
                self.ev.trigger("hideLoadingAfterInitAssets");
                self.checkForVideoSlideAndPlay(initialSlide);
                self.checkForVideoSlideToShowMuteButton(initialSlide);
                self.layers.animateLayer(initialSlide, "startAnimation");
            });

            self.updateTransitionOnResize(self.resizeInfo);
        }
    };

    self.pauseAllVideoSlides = function() {
        self.slides.forEach(function(slide) {
            if (slide.videoObject) {
                slide.videoObject.video.pause();
            }
        });
    };

    init(options);

    function init(initOptions) {
        var initialSlide = initOptions.initialSlide;
        var initialEffect = initOptions.initialEffect;
        var src = self.slides[initialSlide].src;
        var alphaMap = self.slides[initialSlide].alphaMap;
        var slideMediaType = self.slides[initialSlide].mediaType;
        self.loader = new THREE.TextureLoader();

        switch (slideMediaType) {
            case "IMAGE":
                self.loader.load(
                    src,
                    function(texture) {
                        initSlideWithTexture(texture);
                        self.updateRendering(false);
                    },
                    undefined,
                    function(err) {
                        console.error("ERROR on loading texture" + err);
                    }
                );
                break;

            case "VIDEO":
                var videoSlideObject = new STX.VideoSlideObject({
                    height: options.camera.height,
                    width: options.camera.width,
                    src: src
                });
                self.slides[initialSlide].videoObject = videoSlideObject;
                self.slides[initialSlide].videoObject.video.onloadeddata = function() {
                    initSlideWithTexture(self.slides[initialSlide].videoObject.texture);
                };

                break;

            case "NOT_SUPPORTED":
                console.log("Slide media format is not supported, please try with other media file format.");
        }

        function initSlideWithTexture(texture) {
            if (alphaMap && !texture.alphaMap) {
                self.loader.load(
                    alphaMap,
                    function(alphaMapTexture) {
                        alphaMapTexture.minFilter = THREE.LinearFilter;
                        alphaMapTexture.magFilter = THREE.LinearFilter;
                        texture.alphaMap = alphaMapTexture;
                        initSlideWithTexture(texture);
                    },
                    undefined,
                    function(err) {
                        console.error("ERROR on loading texture" + err);
                    }
                );
                return;
            }

            texture.minFilter = THREE.LinearFilter;
            texture.magFilter = THREE.LinearFilter;
            texture.format = THREE.RGBAFormat;
            self.slides[initialSlide].texture = texture;

            self.geometry = new THREE.PlaneGeometry(2, 2);
            self.transitionMaterial = new THREE.ShaderMaterial(THREE[initialEffect + "Shader"]);
            self.transitionMaterial.transparent = true;
            self.slide = new THREE.Mesh(self.geometry, self.transitionMaterial);

            self.effectHandler = new STX.EffectHandler(self.slide, self.ev);
            self.effectHandler.addEffect({
                transitionEffect: initialEffect,
                sliderTextureFrom: self.slides[initialSlide].texture,
                direction: self.slides[initialSlide].direction,
                passes: self.passes
            });
            self.layers.loadLayer(initialSlide, function() {
                self.layers.animateLayer(initialSlide, "startAnimation");
                self.checkForLoadNextTexture(initialSlide + 1);
            });

            self.ev.trigger("initSwiper");
            self.ev.trigger("hideLoadingAfterInitAssets");
            self.checkForVideoSlideAndPlay(initialSlide);
            self.checkForVideoSlideToShowMuteButton(initialSlide);

            self.scene.add(self.slide);

            self.ev.trigger("updateAspectRatio");
            self.render(true);
        }
    }
};

STX.Transition.prototype = {
    updateRendering: function(rendering) {
        this.renderEnabled = rendering;
    },

    animate: function(options) {
        var self = this;

        self.ev.trigger("disableSwiperInteraction");

        self.currentSlideIndex = options.slideTo;
        self.previousSlideIndex = options.slideFrom;
        options.cSlide = options.backwards ? this.slides[options.slideTo] : this.slides[options.slideFrom];

        self.layers.loadLayer(self.currentSlideIndex, function() {
            self.layers.animateLayer(self.previousSlideIndex, "endAnimation", function() {});

            if (self.options.layerStarOnTransitionStart) self.layers.animateLayer(self.currentSlideIndex, "startAnimation");

            self.ev.trigger("showLoading");

            self.getTexture(options.slideTo, function() {
                self.updateRendering(true);
                options.sliderTextureFrom = self.slides[options.slideFrom].texture;
                options.sliderTextureTo = self.slides[options.slideTo].texture;
                self.effectHandler.addEffect({
                    transitionEffect: options.transitionEffect,
                    sliderTextureFrom: self.slides[options.slideFrom].texture,
                    sliderTextureTo: self.slides[options.slideTo].texture,
                    passes: self.passes
                });
                self.checkForVideoSlideToShowMuteButton(options.slideTo);
                self.updateTransitionOnResize(self.resizeInfo);
                self.updateRendering(true);
                self.effectHandler.animate(options, function() {
                    self.checkForVideoSlideAndPause(options.slideFrom);
                    self.checkForVideoSlideAndPlay(options.slideTo);
                });
                self.checkForLoadNextTexture(options.slideTo + 1);
                self.ev.trigger("hideLoading");
            });
        });
    },

    slideMove: function(progress, index, nextIndex, effectIndex) {
        var slide = this.slides[index];
        var nextSlide = this.slides[nextIndex];
        var cSlide = this.slides[effectIndex];

        if (cSlide.brightness === "flash") cSlide.brightness = 10;
        if (cSlide.brightness === "fade") cSlide.brightness = 0;

        this.effectHandler.slideMove({ progress: progress, cSlide: cSlide, textureFrom: slide.texture, textureTo: nextSlide.texture, passes: this.passes });
        this.updateTransitionOnResize(this.resizeInfo);
    },

    updateTransitionOnResize: function(resizeInfo) {
        var self = this;
        var currentSlide = self.slides[self.currentSlideIndex];
        self.resizeInfo = resizeInfo;

        if (self.slide) {
            if (!currentSlide.texture) return;

            var currentTexture = self.effectHandler.currentEffect.uniforms.transitionFrom.value.image;

            if (self.effectHandler.currentEffect.setSize) {
                self.effectHandler.currentEffect.setSize(resizeInfo);
                self.slide.scale.x = 1;
                self.slide.scale.y = 1;
            } else {
                var slideWrapperAspect = resizeInfo.width / resizeInfo.height;
                var materialWidth = currentTexture.width || currentTexture.videoWidth;
                var materialHeight = currentTexture.height || currentTexture.videoHeight;
                var materialAspect = materialWidth / materialHeight;

                var horizontalDrawAspect = materialAspect / slideWrapperAspect;
                var verticalDrawAspect = 1;

                if (horizontalDrawAspect < 1) {
                    verticalDrawAspect /= horizontalDrawAspect;
                    horizontalDrawAspect = 1;
                }
                self.slide.scale.x = horizontalDrawAspect;
                self.slide.scale.y = verticalDrawAspect;
            }

            self.renderOnce();
        }
    },

    enableRendering: function() {
        if (!this.renderEnabled) {
            this.renderEnabled = true;
        }
    },

    disableRendering: function() {
        if (!this.effectHandler.currentEffect.animating && this.renderEnabled) {
            this.renderEnabled = false;
        }
    },

    renderOnce: function() {
        this.needsUpdate = true;
    }
};


STX.TransitionSwipe = function(options) {
    var self = this;
    self.options = options;
    self.ev = self.options.ev;

    self.ev.on("slideChangeTransitionEnd", function() {
        if (!options.layerStarOnTransitionStart) self.layers.animateLayer(self.currentSlideIndex, "startAnimation");
        self.ev.trigger("enableSwiperInteraction");
    });

    self.ev.on("onMuteButtonUpdate", function(event, muted) {
        self.updateVideoSlidesWithMuteStatus(muted);
    });
    self.ev.on("onPauseButtonUpdate", function(event, paused) {
        self.updateVideoSlidesWithPauseStatus(paused);
    });

    self.container = self.options.container;

    self.swiperContainer = options.swiperContainer;
    self.swiperSlides = self.swiperContainer.querySelectorAll(".swiper-slide");

    if (options.parallax) {
        self.swiperSlides.forEach(function(slide) {
            slide.classList.add("stx-parallax");
            slide.dataset.stxParallax = options.parallax;
        });
    }

    self.slides = {};
    self.slides = self.options.slidesToLoad;
    self.currentSlideIndex = self.options.initialSlide;
    self.previousSlideIndex = self.currentSlideIndex;

    self.sliderPaused = false;

    self.layers = options.layers;

    self.getTexture = function(textureId, callback) {
        if (self.slides[textureId].src.match(location.host)) self.slides[textureId].src = self.slides[textureId].src.replace("http:", location.protocol).replace("https:", location.protocol);

        var slideMediaType = self.slides[textureId].mediaType;

        switch (slideMediaType) {
            case "IMAGE":
                if (!self.slides[textureId].texture) {
                    self.checkForVideoSlideAndPause(self.previousSlideIndex);
                    self.loader.load(
                        self.slides[textureId].src,
                        function(texture) {
                            self.bufferSlideTexture(texture, textureId, callback);
                        },
                        undefined,
                        function(err) {
                            console.error("ERROR on loading texture" + err);
                        }
                    );
                } else {
                    self.bufferSlideTexture(self.slides[textureId].texture, textureId, callback);
                }
                break;

            case "VIDEO":
                if (!self.slides[textureId].videoObject) {
                    for (var index = 0; index < self.slides.length; index++) {
                        if (self.slides[index].videoObject && !self.slides[textureId].videoObject && index !== textureId && self.slides[index].src === self.slides[textureId].src) {
                            self.slides[textureId].videoObject = self.slides[index].videoObject;
                        }
                    }
                }

                if (!self.slides[textureId].videoObject) {
                    self.slides[textureId].videoObject = new STX.VideoSlideObject({
                        height: options.camera.height,
                        width: options.camera.width,
                        src: self.slides[textureId].src
                    });
                }

                var texture = self.slides[textureId].videoObject.video;

                if (self.slides[textureId].videoObject.video.readyState < 3) {
                    if (textureId === self.currentSlideIndex) {
                        self.checkForVideoSlideAndPause(self.previousSlideIndex);
                    }
                    self.slides[textureId].videoObject.video.onloadeddata = function() {
                        self.bufferSlideTexture(texture, textureId, callback);
                    };
                } else {
                    self.bufferSlideTexture(texture, textureId, callback);
                }

                break;

            case "NOT_SUPPORTED":
                console.log("Slide media format is not supported, please try with other media file format.");
        }
    };

    self.bufferSlideTexture = function(texture, textureId, callback) {
        self.slides[textureId].texture = texture;

        switch (texture.tagName) {
            case "VIDEO":
                self.swiperSlides[textureId].appendChild(texture);
                break;
            case "IMG":
                self.swiperSlides[textureId].style.backgroundImage = 'url("' + texture.src + '")';
                break;
        }

        if (callback) {
            callback();
        }
    };

    self.checkForLoadNextTexture = function(textureId) {
        if (self.slides.length === textureId) {
            textureId = 0;
        }
        if (!self.slides[textureId].texture && self.slides.length >= textureId + 1) {
            self.layers.loadLayer(textureId, function() {
                self.getTexture(textureId);
            });
        }
    };

    self.checkForVideoSlideAndPlay = function(slideIndex) {
        if (self.slides[slideIndex].videoObject && !self.sliderPaused) {
            if (self.options.resetVideos) self.slides[slideIndex].videoObject.video.currentTime = 0;
            if (self.options.videoAutoplay) self.slides[slideIndex].videoObject.video.play();
        }
    };

    self.checkForVideoSlideAndPause = function(slideIndex) {
        if (self.slides[slideIndex].videoObject) {
            self.slides[slideIndex].videoObject.video.pause();
        }
    };

    self.checkForVideoSlideToShowMuteButton = function(slideIndex) {
        if (self.slides[slideIndex].videoObject) {
            self.ev.trigger("showVideoButtons");
        } else {
            self.ev.trigger("hideVideoButtons");
        }
    };

    self.updateVideoSlidesWithMuteStatus = function(muted) {
        self.slides.forEach(function(slide) {
            if (slide.videoObject) {
                slide.videoObject.video.muted = muted;
            }
        });
    };

    self.updateVideoSlidesWithPauseStatus = function(paused) {
        if (paused) {
            self.slides.forEach(function(slide) {
                if (slide.videoObject) {
                    slide.videoObject.video.pause();
                    self.sliderPaused = true;
                }
            });
        } else {
            if (self.slides[self.currentSlideIndex].videoObject) {
                self.slides[self.currentSlideIndex].videoObject.video.play();
                self.sliderPaused = false;
            }
        }
    };

    self.render = function render() {};

    self.reloadTransition = function(options) {
        var initialSlide = options.initialSlide;
        var initialEffect = options.initialEffect;

        self.options = options;
        self.slides = {};
        self.slides = options.slidesToLoad;
        self.currentSlideIndex = self.options.initialSlide;
        self.previousSlideIndex = self.currentSlideIndex;

        self.ev.trigger("showLoading");

        var slideMediaType = self.slides[initialSlide].mediaType;
        var src = self.slides[initialSlide].src;

        switch (slideMediaType) {
            case "IMAGE":
                self.loader.load(
                    src,
                    function(texture) {
                        setupTransitionAfterReload(texture, initialSlide, initialEffect);
                    },
                    undefined,
                    function(err) {
                        console.error("ERROR on loading texture" + err);
                    }
                );
                break;

            case "VIDEO":
                var videoSlideObject = new STX.VideoSlideObject({
                    height: options.camera.height,
                    width: options.camera.width,
                    src: src
                });
                self.slides[initialSlide].videoObject = videoSlideObject;
                self.slides[initialSlide].videoObject.video.onloadeddata = function() {
                    setupTransitionAfterReload(self.slides[initialSlide].videoObject.texture, initialSlide, initialEffect);
                };

                break;

            case "NOT_SUPPORTED":
                console.log("Slide media format is not supported, please try with other media file format.");
        }

        function setupTransitionAfterReload(texture, initialSlide, initialEffect) {
            self.bufferSlideTexture(texture, initialSlide);
            self.checkForLoadNextTexture(initialSlide + 1);

            self.layers.loadLayer(initialSlide, function() {
                self.ev.trigger("initSwiper");
                self.ev.trigger("hideLoadingAfterInitAssets");
                self.checkForVideoSlideAndPlay(initialSlide);
                self.checkForVideoSlideToShowMuteButton(initialSlide);
                self.layers.animateLayer(initialSlide, "startAnimation");
            });

            self.ev.trigger("updateAspectRatio");
        }
    };

    self.pauseAllVideoSlides = function() {
        self.slides.forEach(function(slide) {
            if (slide.videoObject) {
                slide.videoObject.video.pause();
            }
        });
    };

    init(options);

    function init(initOptions) {
        var initialSlide = initOptions.initialSlide;
        var initialEffect = initOptions.initialEffect;
        var src = self.slides[initialSlide].src;
        var slideMediaType = self.slides[initialSlide].mediaType;
        self.loader = {
            load: function(url, onLoad, onProgress, onError) {
                const image = document.createElementNS("http://www.w3.org/1999/xhtml", "img");

                function onImageLoad() {
                    image.removeEventListener("load", onImageLoad, false);
                    image.removeEventListener("error", onImageError, false);

                    if (onLoad) onLoad(this);
                }

                function onImageError(event) {
                    image.removeEventListener("load", onImageLoad, false);
                    image.removeEventListener("error", onImageError, false);

                    if (onError) onError(event);
                }

                image.addEventListener("load", onImageLoad, false);
                image.addEventListener("error", onImageError, false);

                image.src = url;

                return image;
            }
        };

        switch (slideMediaType) {
            case "IMAGE":
                self.loader.load(
                    src,
                    function(texture) {
                        initSlideWithTexture(texture);
                    },
                    undefined,
                    function(err) {
                        console.error("ERROR on loading texture" + err);
                    }
                );
                break;

            case "VIDEO":
                var videoSlideObject = new STX.VideoSlideObject({
                    height: options.camera.height,
                    width: options.camera.width,
                    src: src
                });
                self.slides[initialSlide].videoObject = videoSlideObject;
                self.slides[initialSlide].videoObject.video.onloadeddata = function() {
                    initSlideWithTexture(self.slides[initialSlide].videoObject.video);
                };

                break;

            case "NOT_SUPPORTED":
                console.log("Slide media format is not supported, please try with other media file format.");
        }

        function initSlideWithTexture(texture) {
            self.slides[initialSlide].texture = texture;

            switch (texture.tagName) {
                case "VIDEO":
                    self.swiperSlides[initialSlide].appendChild(texture);
                    break;
                case "IMG":
                    self.swiperSlides[initialSlide].style.backgroundImage = 'url("' + texture.src + '")';
                    break;
            }

            self.layers.loadLayer(initialSlide, function() {
                self.layers.animateLayer(initialSlide, "startAnimation");
                self.checkForLoadNextTexture(initialSlide + 1);
            });

            self.ev.trigger("initSwiper");
            self.ev.trigger("hideLoadingAfterInitAssets");
            self.checkForVideoSlideAndPlay(initialSlide);
            self.checkForVideoSlideToShowMuteButton(initialSlide);

            self.ev.trigger("updateAspectRatio");
        }
    }
};

STX.TransitionSwipe.prototype = {
    animate: function(options) {
        var self = this;

        self.currentSlideIndex = options.slideTo;
        self.previousSlideIndex = options.slideFrom;

        self.layers.loadLayer(self.currentSlideIndex, function() {
            self.layers.animateLayer(self.previousSlideIndex, "endAnimation", function() {});

            if (self.options.layerStarOnTransitionStart) self.layers.animateLayer(self.currentSlideIndex, "startAnimation");

            self.ev.trigger("showLoading");

            self.getTexture(options.slideTo, function() {
                options.sliderTextureFrom = self.slides[options.slideFrom].texture;
                options.sliderTextureTo = self.slides[options.slideTo].texture;

                self.checkForVideoSlideToShowMuteButton(options.slideTo);
                self.ev.trigger("updateAspectRatio");

                self.checkForLoadNextTexture(options.slideTo + 1);
                self.ev.trigger("hideLoading");
            });
        });
    },

    slideMove: function(progress, index, nextIndex, effectIndex) {
        var slide = this.slides[index];
        var nextSlide = this.slides[nextIndex];
        var cSlide = this.slides[effectIndex];

        if (cSlide.brightness === "flash") cSlide.brightness = 10;
        if (cSlide.brightness === "fade") cSlide.brightness = 0;

        this.ev.trigger("updateAspectRatio");
    },

    updateTransitionOnResize: function(resizeInfo) {},

    enableRendering: function() {},

    disableRendering: function() {}
};


STX.Loading = function(options, ev) {
    var self = this;

    this.options = options;
    this.ev = ev;

    this.loading = document.createElement("div");
    this.loading.className = "stx-loading";

    this.loading.style.setProperty("background-color", options.backgroundColor);

    if (options.color.includes("rgb")) options.color = rgb2hex(options.color);

    this.createPreloader(options);

    setupEventListeners();
    this.ev.trigger("showLoading");

    function rgb2hex(rgb) {
        rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
        return rgb && rgb.length === 4 ? "#" + ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) + ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) + ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2) : "";
    }

    function setupEventListeners() {
        self.ev.on("showLoading", function() {
            self.showLoading();
        });
        self.ev.on("hideLoading", function() {
            self.hideLoading();
        });
    }
};

STX.Loading.prototype = {
    createPreloader: function(options) {
        var self = this;

        self.preloader = document.createElement("div");
        switch (options.style) {
            case "style1":
                self.preloader.className = "stx-preloader-style1";
                var txt = "LOADING".split("").forEach(function(letter) {
                    var w = document.createElement("span");
                    w.className = "stx-loading-text-words";
                    w.style.setProperty("color", options.color);
                    w.innerText = letter;
                    self.preloader.appendChild(w);
                });
                break;
            case "style2":
                self.preloader.className = "stx-preloader-style2";
                self.preloader.style.borderTopColor = hexToRGB(options.color, 0.85);
                self.preloader.style.borderLeftColor = hexToRGB(options.color, 0.85);
                self.preloader.style.borderBottomColor = hexToRGB(options.color, 0.15);
                self.preloader.style.borderRightColor = hexToRGB(options.color, 0.15);
                break;
            case "style3":
                self.preloader.className = "stx-preloader-style3";
                self.preloader.style.borderTopColor = "rgba(0,0,0,0)";
                self.preloader.style.borderLeftColor = hexToRGB(options.color, 0.6);
                self.preloader.style.borderBottomColor = "rgba(0,0,0,0)";
                self.preloader.style.borderRightColor = hexToRGB(options.color, 0.6);
                break;
            case "style4":
                self.preloader.className = "stx-preloader-style4";

                var inner = document.createElement("div");
                inner.className = "stx-preloader-style4-inner";
                self.preloader.appendChild(inner);

                for (var i = 0; i < 5; i++) {
                    var s = document.createElement("span");
                    s.style.setProperty("background", hexToRGB(options.color, 1));
                    inner.appendChild(s);
                }
                break;
        }
        self.loading.appendChild(self.preloader);

        function hexToRGB(hex, alpha) {
            var r = parseInt(hex.slice(1, 3), 16),
                g = parseInt(hex.slice(3, 5), 16),
                b = parseInt(hex.slice(5, 7), 16);

            if (alpha) {
                return "rgba(" + r + ", " + g + ", " + b + ", " + alpha + ")";
            } else {
                return "rgb(" + r + ", " + g + ", " + b + ")";
            }
        }
    },

    hideLoading: function() {
        var self = this;

        if (this.options.fadeEffect) fadeOutLoading();
        else this.loading.style.setProperty("visibility", "hidden");

        function fadeOutLoading() {
            self.loading.classList.add("stx-loading-hide-fadeout");
            self.loading.classList.remove("stx-loading-show-fadein");
        }
    },

    showLoading: function() {
        var self = this;

        if (this.options.fadeEffect) fadeInLoading();
        else this.loading.style.setProperty("visibility", "visible");

        function fadeInLoading() {
            self.loading.classList.add("stx-loading-show-fadein");
            self.loading.classList.remove("stx-loading-hide-fadeout");
        }
    },

    removeStyle: function() {
        var self = this;

        self.preloader.remove();
    },

    createStyle: function(options) {
        var self = this;

        self.createPreloader(options);
    },

    getLoadingDivElement: function() {
        var self = this;

        return self.loading;
    }
};


STX.Thumbnails = function(options, ev) {
    var self = this;

    this.options = options;
    this.ev = ev;

    addHTMLElementsForThumbnails();
    this.setPosition(self.options.thumbs.position);
    this.createThumbnails(self.options);

    function addHTMLElementsForThumbnails() {
        var mediaType;
        var mediaSrc;

        self.swiperThumbsContainerDiv = document.createElement("div");
        self.swiperThumbsContainerDiv.className = "swiper-container gallery-thumbs";
        self.swiperThumbsWrapperDiv = document.createElement("div");
        self.swiperThumbsWrapperDiv.className = "swiper-wrapper";
        self.swiperThumbsContainerDiv.appendChild(self.swiperThumbsWrapperDiv);
        self.swiperThumbsContainerDiv.style.overflow = "hidden";

        for (var i = 0; i < options.slides.length; i++) {
            var thumbSlideDiv = document.createElement("div");
            thumbSlideDiv.className = "swiper-slide";
            thumbSlideDiv.style.width = options.thumbs.thumbWidth + "px";
            thumbSlideDiv.style.height = options.thumbs.thumbHeight + "px";

            if (options.slides[i].thumbSrc) {
                mediaType = options.slides[i].thumbMediaType;
                mediaSrc = options.slides[i].thumbSrc;
            } else {
                mediaType = options.slides[i].mediaType;
                mediaSrc = options.slides[i].src;
            }

            if (mediaType === "IMAGE") thumbSlideDiv.style.setProperty("background-image", "url(" + mediaSrc + ")");
            else {
                captureImageFromVideo(mediaSrc, thumbSlideDiv, function(src, thumbDiv) {
                    thumbDiv.style.setProperty("background-image", "url(" + src + ")");
                });
            }

            self.swiperThumbsWrapperDiv.appendChild(thumbSlideDiv);
        }
    }

    function captureImageFromVideo(src, thumbDiv, callback) {
        var video = document.createElement("video");
        var image = new Image();

        video.autoplay = true;
        video.loop = true;
        video.muted = true;
        video.setAttribute("playsinline", "");
        video.setAttribute("src", src);
        video.setAttribute("crossOrigin", "anonymous");
        video.preload = "auto";
        video.load();
        video.onloadeddata = function() {
            var canvas = document.createElement("canvas");
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext("2d").drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
            image.src = canvas.toDataURL();
            callback(image.src, thumbDiv);
            video.pause();
            video = null;
        };
    }
};

STX.Thumbnails.prototype = {
    createThumbnails: function(options) {
        var self = this;

        self.thumbOptions = {
            el: self.swiperThumbsContainerDiv,
            slidesPerView: "auto",
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            roundLengths: true,
            watchOverflow: true,
            direction: self.direction,
            spaceBetween: options.thumbs.spaceBetween || 0
        };

        self.setPosition(options.thumbs.position);
    },

    setPosition: function(position) {
        var self = this;
        self.direction = "horizontal";

        self.swiperThumbsContainerDiv.style.height = "auto";
        self.swiperThumbsContainerDiv.style.width = "auto";
        self.swiperThumbsContainerDiv.style.maxWidth = "100%";
        self.swiperThumbsContainerDiv.style.maxHeight = "100%";
        self.swiperThumbsContainerDiv.style.background = self.options.thumbs.background;

        switch (position) {
            case "top":
                self.swiperThumbsContainerDiv.style.top = "0";
                self.direction = "horizontal";
                if (self.options.thumbs.outsideSlider)
                    self.swiperThumbsContainerDiv.style.marginTop = "-" + String(Number(self.options.thumbs.thumbHeight) + 2 * Number(self.options.thumbs.spaceAround)) + "px";
                if (self.options.thumbs.centered) {
                    self.swiperThumbsContainerDiv.style.left = "50%";
                    self.swiperThumbsContainerDiv.style.transform = "translateX(-50%)";
                }
                break;
            case "left":
                self.swiperThumbsContainerDiv.style.left = "0";
                self.direction = "vertical";
                if (self.options.thumbs.outsideSlider)
                    self.swiperThumbsContainerDiv.style.marginLeft = "-" + String(Number(self.options.thumbs.thumbWidth) + 2 * Number(self.options.thumbs.spaceAround)) + "px";
                if (self.options.thumbs.centered) {
                    self.swiperThumbsContainerDiv.style.top = "50%";
                    self.swiperThumbsContainerDiv.style.transform = "translateY(-50%)";
                } else {
                    self.swiperThumbsContainerDiv.style.top = "0";
                }
                break;
            case "right":
                self.swiperThumbsContainerDiv.style.right = "0";
                self.direction = "vertical";
                if (self.options.thumbs.outsideSlider)
                    self.swiperThumbsContainerDiv.style.marginRight = "-" + String(Number(self.options.thumbs.thumbWidth) + 2 * Number(self.options.thumbs.spaceAround)) + "px";
                if (self.options.thumbs.centered) {
                    self.swiperThumbsContainerDiv.style.top = "50%";
                    self.swiperThumbsContainerDiv.style.transform = "translateY(-50%)";
                } else {
                    self.swiperThumbsContainerDiv.style.top = "0";
                }
                break;
            default:
                self.swiperThumbsContainerDiv.style.bottom = "0";
                if (self.options.thumbs.outsideSlider)
                    self.swiperThumbsContainerDiv.style.marginBottom = "-" + String(Number(self.options.thumbs.thumbHeight) + 2 * Number(self.options.thumbs.spaceAround)) + "px";

                self.direction = "horizontal";
                if (self.options.thumbs.centered) {
                    self.swiperThumbsContainerDiv.style.left = "50%";
                    self.swiperThumbsContainerDiv.style.transform = "translateX(-50%)";
                }
        }

        self.swiperThumbsContainerDiv.style.padding = (self.options.thumbs.spaceAround || 0) + "px";
    },

    removeStyle: function() {
        var self = this;

        self.swiperThumbsContainerDiv.remove();
    },

    createStyle: function(options) {
        var self = this;

        self.createThumbnails(options);
    },

    getLoadingDivElement: function() {
        var self = this;

        return self.swiperThumbsContainerDiv;
    }
};


STX.Lightbox = function(options, ev, mediaType, src) {
    this.options = options;
    this.ev = ev;

    this.createLightbox(mediaType, src);
};

STX.Lightbox.prototype = {
    createLightbox: function(mediaType, src) {
        var self = this;

        self.lightbox = document.createElement("div");
        self.lightbox.className = "stx-lightbox";
        self.lightbox.style.setProperty("width", window.innerWidth.toString() + "px");
        self.lightbox.style.setProperty("height", window.innerHeight.toString() + "px");
        self.lightbox.style.setProperty("position", "fixed");
        self.hideLightbox();

        createCloseButton();
        createOverlay();
        createContainer();
        self.addMedia(mediaType, src);

        function createCloseButton() {
            self.closeButton = document.createElement("a");
            self.closeButton.className = "stx-lightbox-close";
            self.closeButton.href = "#";

            var closeButtonLine = document.createElement("span");
            closeButtonLine.style.setProperty("background-color", self.options.lightbox.closeColor);
            closeButtonLine.style.setProperty("transform", "rotate(45deg)");
            self.closeButton.appendChild(closeButtonLine);
            self.closeButton.appendChild(closeButtonLine.cloneNode(true));
            closeButtonLine.style.setProperty("transform", "rotate(-45deg)");

            self.lightbox.appendChild(self.closeButton);
            jQuery(self.closeButton).click(function() {
                self.hideLightbox();
            });
        }

        function createOverlay() {
            self.overlay = document.createElement("div");
            self.overlay.className = "stx-lightbox-overlay";
            self.overlay.style.setProperty("background-color", self.options.lightbox.backgroundColor);
            self.overlay.style.setProperty("width", window.innerWidth.toString() + "px");
            self.overlay.style.setProperty("height", window.innerHeight.toString() + "px");
            self.lightbox.appendChild(self.overlay);
        }

        function createContainer() {
            self.container = document.createElement("div");
            self.container.className = "stx-lightbox-container";
            self.lightbox.appendChild(self.container);
        }
    },

    addMedia: function(mediaType, src) {
        this.clearMedia();
        switch (mediaType) {
            case "image":
                this.media = document.createElement("img");
                break;
            case "video":
                this.media = document.createElement("video");
                this.media.setAttribute("controls", "controls");
                break;
        }

        if (this.media) {
            this.media.setAttribute("src", src);
            this.media.style.setProperty("max-width", (window.innerWidth * 0.9).toString() + "px");
            this.container.appendChild(this.media);
        }
    },

    updateSize: function() {
        this.lightbox.style.setProperty("width", window.innerWidth.toString() + "px");
        this.lightbox.style.setProperty("height", window.innerHeight.toString() + "px");
        this.overlay.style.setProperty("width", window.innerWidth.toString() + "px");
        this.overlay.style.setProperty("height", window.innerHeight.toString() + "px");
        if (this.media) this.media.style.setProperty("max-width", (window.innerWidth * 0.9).toString() + "px");
    },

    clearMedia: function() {
        jQuery(this.container).empty();
    },

    createStyle: function(options) {
        var closeButtonSpans = this.closeButton.getElementsByTagName('span');

        for(var i = 0; i < closeButtonSpans.length; i++){
            closeButtonSpans[i].style.setProperty("background-color", options.closeColor);
        }

        this.clearMedia();
        this.overlay.style.setProperty("background-color", options.backgroundColor);
    },

    hideLightbox: function() {
        this.lightbox.style.setProperty("visibility", "hidden");
        this.ev.trigger("hidingLightboxElement");
    },

    showLightbox: function() {
        this.lightbox.style.setProperty("visibility", "visible");
        this.ev.trigger("showingLightboxElement");
    },

    getLoadingDivElement: function() {
        return this.lightbox;
    }
};


STX.Layers = function(options, ev, sliderWrapper) {
    var self = this;
    var slides = options.slides;
    self.slides = slides;
    self.options = options;
    self.ev = ev;
    self.$sliderWrapper = sliderWrapper;
    self.elements = [];
    self.background = [];
    self.invertSelectorsColor = [];
    self.instances = [];
    self.appendStyleIDArray = [];

    self.wrapper = document.createElement("div");
    self.wrapper.className = "stx-layers";
    self.$wrapper = jQuery(self.wrapper);

    self.setupSlidesWrapper();
    self.setupElements(slides);
};

STX.Layers.prototype = {
    setupSlidesWrapper: function() {
        var self = this;

        self.slides.forEach(function(slide) {
            if (slide.elements) {
                slide.elements.forEach(function(element) {
                    delete element.node;
                });

                if (!slide.$wrapper) {
                    slide.wrapper = document.createElement("div");
                    slide.wrapper.className = "stx-layer-wrapper";
                    slide.wrapper.style.pointerEvents = "none";
                    slide.$wrapper = jQuery(slide.wrapper);

                    slide.canvas = document.createElement("div");
                    slide.canvas.className = "stx-layers-canvas";
                    slide.$canvas = jQuery(slide.canvas);

                    slide.content = document.createElement("table");
                    slide.content.className = "stx-layers-content";
                    slide.$content = jQuery(slide.content);

                    jQuery(
                        '<tr class="row-top">' +
                        '<td class="col-left"/>' +
                        '<td class="col-center"/>' +
                        '<td class="col-right"/>' +
                        '</tr>' +
                        '<tr class="row-center">' +
                        '<td class="col-left"/>' +
                        '<td class="col-center"/>' +
                        '<td class="col-right"/>' +
                        '</tr>' +
                        '<tr class="row-bottom">' +
                        '<td class="col-left"/>' +
                        '<td class="col-center"/>' +
                        '<td class="col-right"/>' +
                        '</tr>'
                    ).appendTo(slide.$content);

                    slide.content = slide.$content[0];

                    slide.$wrapper.append(slide.$canvas);

                    slide.$wrapper.append(slide.$content);

                    self.$wrapper.append(slide.$wrapper);
                }
            }
        });
    },
    setupElements: function(slides) {
        var self = this;

        for (var index = 0; index < slides.length; index++) {
            if (slides[index].elements) {
                self.elements[index] = slides[index].elements;
            }
            self.background[index] = slides[index].layerBackground;
            self.invertSelectorsColor[index] = slides[index].invertSelectorColor;
        }
    },

    loadLayer: function(index, callback) {
        var self = this;
        var elements = self.elements[index];
        var background = self.background[index];
        var invertSelectorsColor = self.invertSelectorsColor[index];
        var el;
        var r, l, c;

        if (elements) {
            var numberOfElements = elements.length;

            for (var i = 0; i < elements.length; i++) {
                el = elements[i];
                elements[i].width = elements[i].width || "";
                elements[i].height = elements[i].height || "";

                if (!el.hasOwnProperty("node")) {
                    self.createNodeElement(
                        {
                            slideIndex: index,
                            elementIndex: i,
                            element: el
                        },
                        addToLayer
                    );
                } else {
                    addToLayer();
                }

                if (el.mode === "content") {
                    if (el.position.x === "left") l = 1;
                    if (el.position.x === "right") r = 1;
                    if (el.position.x === "center") c = 1;
                }

                function addToLayer() {
                    numberOfElements--;

                    if (!numberOfElements) {
                        if (callback) callback();
                    }
                }
            }

            if (c && (l || r)) self.slides[index].$content.find("td").css("width", "33.33%");
            else self.slides[index].$content.find("td").css("width", "auto");

            self.slides[index].wrapper.style.background = background || "none";
        } else {
            if (callback) callback();
        }
        self.changeSelectorsColor(invertSelectorsColor);
    },

    changeSelectorsColor: function(color) {
        var self = this;
        var selector = self.options.invertColorSelectors;
        var filter = color ? "invert(100%)" : "none";

        if (selector) jQuery(selector).css({ filter: filter, transition: "all 0.50s ease" });
    },

    setOpacity: function(val) {
        this.wrapper.style.opacity = val;
    },

    animateLayer: function(index, animationType, callback) {
        var self = this;
        var elements = self.elements[index];
        var counter = -1;
        var el;
        var pos;
        var view = this.currentView;
        this.currentElements = elements;
        this.currentIndex = index;

        if (elements) {
            var numberOfElements = elements.length;

            if (animationType === "startAnimation") {
                this.setOpacity(1);
                this.slides[index].$wrapper.find("td").empty();
                this.slides[index].wrapper.style.pointerEvents = "auto";

                this.slides[index].$canvas.empty();
            } else {
                this.slides[index].wrapper.style.pointerEvents = "none";

            }

            for (var i = 0; i < elements.length; i++) {
                el = JSON.parse(JSON.stringify(elements[i]));
                el.node = elements[i].node;

                jQuery(el.node)
                    .removeClass("tablet mobile")
                    .addClass(this.currentView);

                if (el[view]) {
                    for (var key in el[view]) {
                        el[key] = el[view][key];
                    }
                }

                if (animationType === "startAnimation") {
                    pos = el.position || {};
                    pos.x = pos.x || "center";
                    pos.y = pos.y || "center";

                    var $container = el.mode === "content" ? this.slides[index].$wrapper.find(".row-" + pos.y).find(".col-" + pos.x) : this.slides[index].$canvas;

                    if (el.parent) {
                        this.slides[index].$wrapper.find("#" + el.parent).append(jQuery(el.node));
                    } else if (el.node.wrapper) {
                        el.node.wrapper.append(jQuery(el.node));
                        $container.append(jQuery(el.node.wrapper));
                    } else {
                        $container.append(jQuery(el.node));
                    }

                    self.updateNodeData(el);

                    if (el.type === "video") el.node.play();
                }
                if (el.node) {
                    if (el[animationType]) {

                        if (el.contentAnimationType === "none" || el[animationType].animation == "none"){
                            el[animationType].animation = "fade"
                            el[animationType].duration = "1"
                         }

                        self.animateCSS(el, el[animationType].animation, animationType, function() {
                            numberOfElements--;
                            if (!numberOfElements) {
                                if (callback) callback();
                            }
                        });
                    } else {
                        numberOfElements--;
                        if (!numberOfElements) {
                            if (callback) callback();
                        }
                    }
                }
            }
        } else {
            if (callback) callback();
        }
    },

    updateNodeData: function(element) {
        if (element.parent || element.type === "row" || element.type === "column" || element.mode === "content") return;

        var el = JSON.parse(JSON.stringify(element));

        var view = this.currentView;

        if (el[view]) {
            for (var key in el[view]) {
                el[key] = el[view][key];
            }
        }

        var $node = jQuery(element.node);

        element.node.style.left = 0;
        element.node.style.top = 0;

        var nodeW = $node.outerWidth();
        var nodeH = $node.outerHeight();
        var offsetX = el.position.offsetX || 0;
        var offsetY = el.position.offsetY || 0;
        var left = "initial",
            right = "initial",
            top = "initial",
            bottom = "initial";

        if (el.position.x === "left") left = offsetX;
        else if (el.position.x === "center") left = "calc(50% - " + nodeW / 2 + "px + " + offsetX + "px)";
        else right = offsetX;

        if (el.position.y === "top") top = offsetY;
        else if (el.position.y === "center") top = "calc(50% - " + nodeH / 2 + "px - " + offsetY + "px)";
        else bottom = offsetY;

        $node.css({
            left: left,
            right: right,
            top: top,
            bottom: bottom
        });
    },

    createNodeElement: function(options, callback) {
        var self = this;

        var el = options.element;
        var fontToLoad = el.fontFamily;
        var fontWeight = el.fontWeight;
        var color = el.color ? el.color : '#FFFFFF';

        if (el.contentAnimationType === "typing")
            el.startAnimation.animation = "effect9";

        switch (el.type) {
            case "text":
                var htmlTag = el.htmlTag || "p";
                var node;
                 if (el.hasOwnProperty("startAnimation"))
                    if (el["startAnimation"].animation.includes("effect")) node = createEffectHTMLNode(el["startAnimation"].animation, color);
                    else node = document.createElement(htmlTag);
                else node = document.createElement(htmlTag);
                break;

            case "heading":
                var htmlTag = el.htmlTag || "h2";
                var node;

                if (el.hasOwnProperty("startAnimation"))
                    if (el["startAnimation"].animation.includes("effect")) node = createEffectHTMLNode(el["startAnimation"].animation, color);
                    else node = document.createElement(htmlTag);
                else node = document.createElement(htmlTag);

                break;

            case "image":
                var node = new Image();
                if (el.src) node.src = el.src;
                if (el.size) {
                    node.style.setProperty("width", el.size + "px");
                    node.style.setProperty("height", "auto");
                }
                node.style.display = "none";
                node.onload = function() {
                    self.updateNodeData(el);
                    node.style.display = "block";
                };
                checkForOnClickAction();
                break;

            case "video":
                var $node = jQuery(
                    '<video width="320" height="240" muted="muted" autoplay="autoplay" loop="loop" playsinline="playsinline" preload="metadata" data-aos="fade-up"><source src="' +
                        el.src +
                        '" type="video/mp4"></video>'
                );
                var node = $node[0];
                if (el.width) node.width = el.width;
                if (el.height) node.height = el.height;
                node.onloadedmetadata = function() {
                    node.height = node.width / (node.videoWidth / node.videoHeight);
                    self.updateNodeData(el);
                };
                node.oncanplaythrough = function() {
                    node.muted = true;
                    node.play();
                    node.pause();
                    node.play();
                };
                checkForOnClickAction();
                break;

            case "iframe":
                var $node = jQuery('<iframe width="320" height="240" frameBorder="0" src="' + el.src + '" ></iframe>');
                var node = $node[0];
                if (el.width) node.width = el.width;
                if (el.height) node.height = el.height;
                node.onload = function() {
                    self.updateNodeData(el);
                };
                checkForOnClickAction();
                break;

            case "button":
                var node = document.createElement("a");
                node.classList.add("stx-layer-button");
                if (el.url) {
                    node.href = el.url;
                    if (el.urlTarget) node.setAttribute("target", "_" + el.urlTarget);
                    else if (el.urlTargetBlank) node.setAttribute("target", "_blank");
                    else node.setAttribute("target", "_self");
                }
                break;
            case "row":
                var node = document.createElement("div");
                node.classList.add("stx-row");
                node.id = el.id;
                break;
            case "column":
                var node = document.createElement("div");
                node.classList.add("stx-column");
                node.id = el.id;
                el.width = el.width || "100%";
                break;
        }

        function createEffectHTMLNode(effectType, color) {
            var node;

            switch (effectType) {
                case "effect1":
                    node = STX.Utils.htmlToElement(
                        '<h1 class="ml1">' +
                            '<span class="text-wrapper">' +
                            '<span class="line line1" style="background-color: ' + color + '"></span>' +
                            '<span class="letters"></span>' +
                            '<span class="line line2" style="background-color: ' + color + '"></span>' +
                            "</span>" +
                            "</h1>"
                    );
                    break;
                case "effect2":
                    node = STX.Utils.htmlToElement('<h1 class="ml2"></h1>');
                    break;
                case "effect3":
                    node = STX.Utils.htmlToElement('<h1 class="ml3"></h1>');
                    break;
                case "effect4":
                    node = STX.Utils.htmlToElement('<h1 class="ml4"> </h1>');
                    break;
                case "effect5":
                    node = STX.Utils.htmlToElement(
                        '<h1 class="ml6">' +
                        '<span class="text-wrapper">' +
                        '<span class="letters"></span>' +
                        '</span>' +
                        "</h1>"
                    );
                    break;
                case "effect6":
                    node = STX.Utils.htmlToElement(
                  '<h1 class="ml7">' +
                        '<span class="text-wrapper">' +
                        '<span class="letters"></span>' +
                        '</span>' +
                        '</h1>'
                    );
                    break;
                case "effect7":
                    node = STX.Utils.htmlToElement(
                        '<h1 class="ml9">' +
                        '<span class="text-wrapper">' +
                        '<span class="letters"></span>' +
                        '</span>' +
                        '</h1>'
                    );
                    break;
                case "effect8":
                    node = STX.Utils.htmlToElement(
                        '<h1 class="ml10">' +
                        '<span class="text-wrapper">' +
                        '<span class="letters"></span>' +
                        '</span>' +
                        '</h1>'
                    );
                    break;
                case "effect9":
                    node = STX.Utils.htmlToElement(
                        '<h1 class="ml11">' +
                        '<span class="text-wrapper">' +
                        '<span class="line line1" style="background-color: ' + color + '"></span>' +
                        '<span class="letters"></span>' +
                        '</span>' +
                        '</h1>'
                    );
                    break;
                case "effect10":
                    node = STX.Utils.htmlToElement('<h1 class="ml12"> </h1>');
                    break;
                case "effect11":
                    node = STX.Utils.htmlToElement('<h1 class="ml13"> </h1>');
                    break;
                case "effect12":
                    node = STX.Utils.htmlToElement(
                        '<h1 class="ml14">' +
                        '<span class="text-wrapper">' +
                        '<span class="letters"></span>' +
                        '<span class="line" style="background-color: ' + color + '"></span>' +
                        '</span>' +
                        '</h1>'
                    );
                    break;
                case "effect13":
                    node = STX.Utils.htmlToElement('<h1 class="ml15"> </h1>');
                    break;
                case "effect14":
                    node = STX.Utils.htmlToElement('<h1 class="ml16"> </h1>');
                    break;

            }
            return node;
        }

        function checkForOnClickAction() {
            if (el.onClick) {
                switch (el.onClick.type) {
                    case "lightbox":
                        if (!self.lightbox) {
                            self.lightbox = new STX.Lightbox(self.options, self.ev, el.type, el.src);
                            self.$sliderWrapper.append(jQuery(self.lightbox.getLoadingDivElement()));
                        }
                        node.addEventListener("click", function() {
                            self.lightbox.addMedia(el.type, el.src);
                            self.lightbox.showLightbox();
                        });
                }
            }
        }

        el.node = node;
        el.$node = jQuery(node);
        node.dataset.id = "" + String(Date.now()) + parseInt(Math.random() * 100);
        node.id = "n" + node.dataset.id;
        node.wrapper = jQuery(document.createElement("div"));
        node.wrapper.append(jQuery(node));
        if (el.display) node.wrapper.css("display", el.display);

        if (el.parallax) {
            node.wrapper.addClass("stx-parallax").attr("data-stx-parallax", el.parallax);
            if (el.mode != "content" && el.type != "row" && el.type != "column") node.wrapper.addClass("stx-parallax-abs");
            if (el.parallaxDuration) node.wrapper.css("transition", "transform " + el.parallaxDuration / 1000 + "s cubic-bezier(0,0,0.2,1)");
            if (el.zIndex) node.wrapper.css("zIndex", el.zIndex);
        }

        var font = fontToLoad;
        var fontVariationsToLoad = 2;

        if (font && font != "initial") {
            if (font.startsWith('"') || font.startsWith("'")) font = font.slice(1, -1);

            WebFont.load({
                google: {
                    families: [font, font + ":" + fontWeight]
                },
                fontactive: function() {
                    --fontVariationsToLoad;
                    if (fontVariationsToLoad <= 0) {
                        self.setProperties(el);
                        if (callback) callback();
                    }
                },
                fontinactive: function() {
                    --fontVariationsToLoad;
                    if (fontVariationsToLoad <= 0) {
                        self.setProperties(el);
                        if (callback) callback();
                    }
                }
            });
        } else {
            self.setProperties(el);
            if (callback) callback();
        }
    },

    cssValue: function(name, val) {
        return isNaN(val) || name === "fontWeight" || val == "" ? val : val + "px";
    },

    setProperties: function(el) {
        var self = this;

        var style = {};
        var styleMobile = {};
        var styleTablet = {};
        var styleHover = {};
        var node = el.node;
        var $node = jQuery(node);

        if (el.hasOwnProperty("startAnimation") && el.hasOwnProperty("content") && ( el.type === "heading" || el.type === "text") ) {
            if (el["startAnimation"].animation.includes("effect")) {
                switch (el["startAnimation"].animation) {
                    case "effect1":
                        el.node.querySelector(".ml1 .letters").innerHTML = el.content;
                        break;

                    case "effect2":
                    case "effect3":
                    case "effect10":
                    case "effect11":
                    case "effect14":
                        el.node.innerHTML = el.content;
                        break;
                    case "effect4":
                        var wordsArray = el.content.split(";");
                        for(var i = 0; i < wordsArray.length; i++) {
                            el.node.append(STX.Utils.htmlToElement('<span class="letters letters-' + (i+1) + '">' + wordsArray[i] + '</span>'));
                        }
                        break;
                    case "effect5":
                        el.node.querySelector(".ml6 .letters").innerHTML = el.content;
                        break;
                    case "effect6":
                        el.node.querySelector(".ml7 .letters").innerHTML = el.content;
                        break;
                    case "effect7":
                        el.node.querySelector(".ml9 .letters").innerHTML = el.content;
                        break;
                    case "effect8":
                        el.node.querySelector(".ml10 .letters").innerHTML = el.content;
                        break;
                    case "effect9":
                        el.node.querySelector(".ml11 .letters").innerHTML = el.content;
                        break;
                    case "effect12":
                        el.node.querySelector(".ml14 .letters").innerHTML = el.content;
                        break;
                    case "effect13":
                        var wordsArray = el.content.split(";");
                        for(var i = 0; i < wordsArray.length; i++) {
                            el.node.append(STX.Utils.htmlToElement('<span class="word">' + wordsArray[i] + '</span>'));
                        }
                        break;
                }
            }else if(el.hasOwnProperty("content") && !node.innerHTML) {
                node.innerHTML = el.content;
            }
        } else if (el.hasOwnProperty("content") && !node.innerHTML) {
            node.innerHTML = el.content;
        }

        var props = STX.Utils.cssProperties;
        for (var prop in props) {
            if (el[prop] != "") style[props[prop]] = self.cssValue(prop, el[prop] || "");
        }

        if (el.mobile) {
            for (var prop in props) {
                if (el.mobile[prop] != "") styleMobile[props[prop]] = self.cssValue(prop, el.mobile[prop] || "");
            }
        }

        if (el.tablet) {
            for (var prop in props) {
                if (el.tablet[prop] != "") styleTablet[props[prop]] = self.cssValue(prop, el.tablet[prop] || "");
            }
        }

        if (el.hover) {
            for (var prop in props) {
                if (el.hover[prop] != "") styleHover[props[prop]] = self.cssValue(prop, el.hover[prop] || "");
            }
        }

        function appendStyle(styles, id) {
            var css = document.createElement("style");
            css.type = "text/css";
            css.id = id;
            self.appendStyleIDArray.push(id);

            if (css.styleSheet) css.styleSheet.cssText = styles;
            else css.appendChild(document.createTextNode(styles));

            document.body.appendChild(css);
        }

        function createStyle(className, properties, customCSS, mobileProperties, tabletProperties, hoverProperties, type) {
            if (!properties) return "";

            var style = className + "{";
            var cssPropertyName = "";
			var arr = ["margin-top", "margin-bottom", "margin-right", "margin-left"]

            Object.keys(properties).forEach(function(property) {
                cssPropertyName = STX.Utils.camelToDash(property);
                if ("textColor" === property) cssPropertyName = "color";
                if (properties[property] != "") style += cssPropertyName + ":" + properties[property] + ";";
				else{
					jQuery.each(arr, function(index, value) {
						if (cssPropertyName == arr[index]) {
							style += cssPropertyName + ":" + "0px" + ";";
						}
					});
				}
            });

            if (customCSS) style += customCSS;

            style += "}";

            if (type === "text") {
                style += className + " p {";
                jQuery.each(arr, function (index, value) {
                    style += value + ":unset;";
                });
                style += "}";
            }


            style += className + ":hover{";

            Object.keys(hoverProperties).forEach(function(property) {
                cssPropertyName = STX.Utils.camelToDash(property);
                if ("textColor" === property) cssPropertyName = "color";
                if (hoverProperties[property] != "") style += cssPropertyName + ":" + hoverProperties[property] + ";";
            });

            if (el.onClick && el.onClick.type !== "none") style += "cursor: pointer;";

            style += "}";


            style += className;

            style += ".tablet{";

            Object.keys(tabletProperties).forEach(function(property) {
                cssPropertyName = STX.Utils.camelToDash(property);
                if ("textColor" === property) cssPropertyName = "color";
                if (tabletProperties[property] != "") style += cssPropertyName + ":" + tabletProperties[property] + ";";
            });

            style += "}";


            style += className;

            style += ".mobile{";

            Object.keys(mobileProperties).forEach(function(property) {
                cssPropertyName = STX.Utils.camelToDash(property);
                if ("textColor" === property) cssPropertyName = "color";
                if (mobileProperties[property] != "") style += cssPropertyName + ":" + mobileProperties[property] + ";";
            });

            style += "}";

            return style;
        }

        if (!this.styles) this.styles = {};
        if (!this.styles[node.dataset.id]) {
            var s = createStyle("#n" + node.dataset.id, style, el.customCSS, styleMobile, styleTablet, styleHover, el.type);
            appendStyle(s, "s" + node.dataset.id);
            this.styles[node.dataset.id] = s;
        }

        if (el.type === "row" || el.type === "column") {
            node.style.setProperty("float", "left");
            node.style.setProperty("height", el.height);
            node.style.setProperty("width", el.width);
            node.style.setProperty("overflow", "hidden");
            node.style.setProperty("text-align", el.textAlign || "initial");
            node.style.setProperty("z-index", "1");
        } else if (el.parent || el.mode === "content") {
            node.style.setProperty("white-space", "pre-line");
            node.style.setProperty("position", "initial");
        } else {
            node.style.setProperty("position", "absolute");
            node.style.setProperty("white-space", "pre-wrap");
        }
    },

    animateCSS: function(element, animationName, animationType, callback) {
        var self = this;
        var textWrapper;

        if (!animationName) animationName = "fade";

        var has = function(val) {
            return animationName.includes(val);
        };

        var el = element.node;
        el.style.transition = "all 0s";

        var o = { targets: el };
        o.easing = "easeOutQuad";

        var offset = self.$sliderWrapper.width() + "px";
        var angle = 0;
        var opacity = 1;

        if(animationName === "bounceIn") {
            o.easing = "spring(1, 100, 10, 0)";
            o.scale = [0.3, 1];
            opacity = 0;
        } else if (has("bounce")) {
            o.easing = "spring(.7, 100, 10, 0)";
            offset = self.$sliderWrapper.width() + "px";
            opacity = 0;
        }

        if (has("flip")) {
            if(has("InX")) {
                o.rotateX = ["90deg", 0];
            } else if(has("InY")) {
                o.rotateY = ["90deg", 0];
            }else if(has("OutX")) {
                o.rotateX = ["90deg"];
            }else if(has("OutY")) {
                o.rotateY = ["90deg"];
            }
            opacity = 0
        }

        if (has("fade") || has("zoom")) opacity = 0;

        if (has("rotate")) {
            if (has("UpLeft")) {
                el.style.transformOrigin = "left bottom";
                angle = "45deg";
            } else if (has("UpRight")) {
                el.style.transformOrigin = "right bottom";
                angle = "-90deg";
            } else if (has("DownLeft")) {
                el.style.transformOrigin = "left bottom";
                angle = "-45deg";
            } else if (has("DownRight")) {
                el.style.transformOrigin = "right bottom";
                angle = "45deg";
            } else {
                el.style.transformOrigin = "center";
                angle = "-200deg";
            }
            opacity = 0;
        }

        if (has("lightSpeed")) {
            offset = self.$sliderWrapper.width() + "px";
            angle = "-180deg";
        }

        if (has("Big")) {
            offset = (1.5 * self.$sliderWrapper.width()) + "px";
        }

        if (animationType === "endAnimation") {
            anime.remove(el);

            if (opacity != 1) o.opacity = opacity;

            if (has("zoom")) {
                o.scale = 0.3;
            }

            if (!has("rotate")) {
                if (has("Left")) o.translateX = "-" + offset;
                else if (has("Right")) o.translateX = offset;
                else if (has("Down")) o.translateY = offset;
                else if (has("Up")) o.translateY = "-" + offset;
            }

            if (has("lightSpeed")) {
                o.translateX = offset;
                o.skewX = angle;
                o.easing = "spring(.4, 100, 10, 0)";
            }

            if (has("rotate")) o.rotateZ =  String(Number(angle.replace("deg","")) * -1 ) + "deg"

            o.delay = 0;
            o.duration = element[animationType].speed || 300;

            o.complete = function() {
                el.style.transition = "";
                el.style.transform = "";
                el.style.opacity = 0;
                el.style.pointerEvents = "none"
                el.parentNode.style.pointerEvents = "none"
            };



            anime(o);
        } else {
            anime.remove(el);

            el.style.opacity = 1;

            if (opacity != 1) o.opacity = [opacity, 1];

            if (has("zoom")) {
                o.scale = [0.3, 1];
            }
            if (!has("rotate")) {
                if (has("Left")) o.translateX = ["-" + offset, 0];
                else if (has("Right")) o.translateX = [offset, 0];
                else if (has("Up")) o.translateY = [offset, 0];
                else if (has("Down")) o.translateY = ["-" + offset, 0];
            }

            if (has("lightSpeed")) {
                o.translateX = [offset, 0];
                o.skewX = [angle, 0];
                o.easing = "spring(.4, 100, 10, 0)";
            }

            if (has("rotate")) o.rotateZ = [angle, 0];

            o.delay = element[animationType].delay || 0;
            if (!element["startAnimation"].animation.includes("effect")) o.duration = element[animationType].speed || 300;
            else o.duration = element[animationType].speed;

            if (element.direction) o.direction = element.direction;
            if (element.endDelay) o.endDelay = element.endDelay;
            if (element.loop) o.loop = element.loop;

            o.complete = function() {
                el.style.transition = "";
                el.style.transform = "";
                el.style.pointerEvents = ""
                el.parentNode.style.pointerEvents = ""
            };

            var a = anime(o);

            if (element.loop) {
                var arr = element.content.split(";");
                var loopCount = -1;
                a.loopBegin = function() {
                    loopCount++;
                    if (loopCount % 2 == 0) el.innerText = arr[(loopCount / 2) % arr.length];
                };
            }

            if (element["startAnimation"].animation.includes("effect") && (element.type === "heading" || element.type == "text")) {
                switch (element["startAnimation"].animation) {
                    case "effect1":
                        o.duration = o.duration || 1000;

                        textWrapper = element.node.querySelector(".letters");
                        textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

                        anime
                            .timeline({
                                loop: o.loop
                            })
                            .add({
                                delay: o.delay
                            })
                            .add({
                                targets: element.node.querySelectorAll(".ml1 .letter"),
                                scale: [0.3, 1],
                                opacity: [0, 1],
                                translateZ: 0,
                                easing: "easeOutExpo",
                                duration: o.duration / 2,
                                delay: (el, i, l) => ((o.duration / 2) / l) * (i + 1)
                            })
                            .add({
                                targets: element.node.querySelectorAll(".ml1 .line"),
                                scaleX: [0, 1],
                                opacity: [0.5, 1],
                                easing: "easeOutExpo",
                                duration: o.duration / 2,
                                offset: "-=875",
                                delay: (el, i, l) => 80 * (l - i)
                            });
                        break;

                    case "effect2":
                        o.duration = o.duration || 1000;

                        textWrapper = element.node;
                        textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

                        anime
                            .timeline({
                                loop: o.loop
                            })
                            .add({
                                delay: o.delay
                            })
                            .add({
                                targets: element.node.querySelectorAll(".ml2 .letter"),
                                scale: [4, 1],
                                opacity: [0, 1],
                                translateZ: 0,
                                easing: "easeOutExpo",
                                duration: o.duration,
                                delay: (el, i, l) => o.duration / l * i
                            });
                        break;

                    case "effect3":
                        o.duration = o.duration || 1000;

                        textWrapper = element.node;
                        textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

                        anime
                            .timeline({
                                loop: o.loop
                            })
                            .add({
                                delay: o.delay
                            })
                            .add({
                                targets: element.node.querySelectorAll(".ml3 .letter"),
                                opacity: [0,1],
                                easing: "easeInOutQuad",
                                duration: o.duration,
                                delay: (el, i, l) => (o.duration / l) * (i+1)
                            });
                        break;
                    case "effect4":
                        o.duration = o.duration || 1000;

                        var ml4 = {};
                        ml4.opacityIn = [0,1];
                        ml4.scaleIn = [0.2, 1];
                        ml4.scaleOut = 3;
                        ml4.durationIn = o.duration;
                        ml4.durationOut = o.duration;
                        ml4.delay = o.delay;

                        var numberOfWords = element.node.querySelectorAll(".letters").length;
                        var animation = anime
                            .timeline({
                                loop: o.loop
                            });
                        animation
                            .add({
                                delay: o.delay
                            });

                        for(var i = 1; i <= numberOfWords; i++) {
                            animation
                                .add({
                                    targets: element.node.querySelectorAll('.ml4 .letters-' + i),
                                    opacity: ml4.opacityIn,
                                    scale: ml4.scaleIn,
                                    duration: ml4.durationIn
                                })
                                .add({
                                    targets: element.node.querySelectorAll('.ml4 .letters-' + i),
                                    opacity: 0,
                                    scale: ml4.scaleOut,
                                    duration: ml4.durationOut,
                                    easing: "easeInExpo",
                                    delay: o.delay
                                })
                        }
                        break;
                    case "effect5":
                        o.duration = o.duration || 1000;

                        textWrapper = element.node.querySelector(".letters");
                        textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

                        anime
                            .timeline({
                                loop: o.loop
                            })
                            .add({
                                delay: o.delay
                            })
                            .add({
                                targets: element.node.querySelectorAll('.ml6 .letter'),
                                translateY: ["1.2em", 0],
                                translateZ: 0,
                                duration: o.duration,
                                delay: (el, i, l) => o.duration / l * i
                            });
                        break;
                    case "effect6":
                        o.duration = o.duration || 1000;

                        textWrapper = element.node.querySelector(".letters");
                        textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

                        anime
                            .timeline({
                                loop: o.loop
                            })
                            .add({
                                delay: o.delay
                            })
                            .add({
                                targets: element.node.querySelectorAll('.ml7 .letter'),
                                translateY: ["1.1em", 0],
                                translateX: ["0.55em", 0],
                                translateZ: 0,
                                rotateZ: [180, 0],
                                duration: o.duration,
                                easing: "easeOutExpo",
                                delay: (el, i, l) => o.duration / l * i
                            });
                        break;
                    case "effect7":
                        o.duration = o.duration || 1000;

                        textWrapper = element.node.querySelector(".letters");
                        textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

                        anime
                            .timeline({
                                loop: o.loop
                            })
                            .add({
                                delay: o.delay
                            })
                            .add({
                                targets: element.node.querySelectorAll('.ml9 .letter'),
                                scale: [0, 1],
                                duration: o.duration,
                                elasticity: 600,
                                delay: (el, i, l) => (o.duration / l) * (i+1)
                            });
                        break;
                    case "effect8":
                        o.duration = o.duration || 1000;

                        textWrapper = element.node.querySelector(".letters");
                        textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

                        anime
                            .timeline({
                                loop: o.loop
                            })
                            .add({
                                delay: o.delay
                            })
                            .add({
                                targets: element.node.querySelectorAll('.ml10 .letter'),
                                rotateY: [-90, 0],
                                duration: o.duration,
                                delay: (el, i, l) => o.duration / l * i
                            });
                        break;
                    case "effect9":
                        o.duration = o.duration || 500;

                        textWrapper = element.node.querySelector(".letters");
                        textWrapper.innerHTML = textWrapper.textContent.replace(/([^\x00-\x80]|\w)/g, "<span class='letter'>$&</span>");
                        var textDelay = '-=' + (o.duration * 2);

                        anime
                            .timeline({
                                loop: o.loop
                            })
                            .add({
                                delay: o.delay
                            })
                            .add({
                                targets: element.node.querySelectorAll('.ml11 .line'),
                                scaleY: [0,1],
                                opacity: [0.5,1],
                                easing: "easeOutExpo",
                                duration: 700
                            })
                            .add({
                                targets: element.node.querySelector('.ml11 .line'),
                                translateX: [0, element.node.querySelector('.ml11 .letters').getBoundingClientRect().width + 4],
                                easing: "easeOutExpo",
                                duration: o.duration * 2
                            })
                            .add({
                                targets: element.node.querySelectorAll('.ml11 .letter'),
                                opacity: [0,1],
                                easing: "easeOutExpo",
                                duration: 600,
                                delay: (el, i, l) => o.duration / l * (i+1)
                            }, textDelay)
                            .add({
                                targets: element.node.querySelectorAll('.ml11 .line'),
                                scaleY: [1,0],
                                opacity: [0.5,1],
                                easing: "easeOutExpo",
                                duration: 400
                            }, '-=300');
                        break;
                    case "effect10":
                        o.duration = o.duration || 1200;

                        textWrapper = element.node;
                        textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

                        anime
                            .timeline({
                                loop: o.loop
                            })
                            .add({
                                delay: o.delay
                            })
                            .add({
                                targets: element.node.querySelectorAll(".ml12 .letter"),
                                translateX: [40,0],
                                translateZ: 0,
                                opacity: [0,1],
                                easing: "easeOutExpo",
                                duration: o.duration,
                                delay: (el, i, l) => 500 + (o.duration / l) * i
                            });
                        break;
                    case "effect11":
                        o.duration = o.duration || 1400;

                        textWrapper = element.node;
                        textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

                        anime
                            .timeline({
                                loop: o.loop
                            })
                            .add({
                                delay: o.delay
                            })
                            .add({
                                targets: element.node.querySelectorAll(".ml13 .letter"),
                                translateY: [100,0],
                                translateZ: 0,
                                opacity: [0,1],
                                easing: "easeOutExpo",
                                duration: o.duration,
                                delay: (el, i, l) => 300 + (o.duration / l) * i
                            });
                        break;
                    case "effect12":
                        o.duration = o.duration || 1100;

                        textWrapper = element.node.querySelector(".letters");
                        textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
                        var textDelay = '-=' + (o.duration / 2);

                        anime
                            .timeline({
                                loop: o.loop
                            })
                            .add({
                                delay: o.delay
                            })
                            .add({
                                targets: element.node.querySelector('.ml14 .line'),
                                scaleX: [0,1],
                                opacity: [0.5,1],
                                easing: "easeInOutExpo",
                                duration: o.duration - 200
                            })
                            .add({
                                targets: element.node.querySelectorAll('.ml14 .letter'),
                                opacity: [0,1],
                                translateX: [40,0],
                                translateZ: 0,
                                scaleX: [0.3, 1],
                                easing: "easeOutExpo",
                                duration: o.duration - 300,
                                delay: (el, i, l) => 150 + (o.duration / l) * i
                            }, textDelay);
                        break;
                    case "effect13":
                        o.duration = o.duration || 800;

                        anime
                            .timeline({
                                loop: o.loop
                            })
                            .add({
                                delay: o.delay
                            })
                            .add({
                                targets: element.node.querySelectorAll('.ml15 .word'),
                                scale: [14,1],
                                opacity: [0,1],
                                easing: "easeOutCirc",
                                duration: o.duration,
                                delay: (el, i) => o.duration * i
                            });
                        break;
                    case "effect14":
                        o.duration = o.duration || 1400;

                        textWrapper = element.node;
                        textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

                        anime
                            .timeline({
                                loop: o.loop
                            })
                            .add({
                                delay: o.delay
                            })
                            .add({
                                targets: element.node.querySelectorAll('.ml16 .letter'),
                                translateY: [-100,0],
                                easing: "easeOutExpo",
                                duration: o.duration,
                                delay: (el, i, l) => (o.duration / l) * i
                            });
                        break;
                }
            } else {
                if (element.delay) {
                    a.pause();
                    setTimeout(function() {
                        a.play();
                    }, element.delay);
                } else a.play();
            }
        }
    },

    reloadLayer: function(options) {
        var self = this;

        self.elements = [];
        self.appendStyleIDArray.forEach(function(appendStyleID) {
            jQuery("#" + appendStyleID).remove();
        });
        self.appendStyleIDArray = [];
        self.$wrapper.find("td").empty();
        self.$wrapper.find(".stx-layers-canvas").empty();
        if (self.lightbox) self.lightbox.createStyle(options.lightbox);
        self.slides = options.slides;
        self.setupSlidesWrapper();
        self.setupElements(options.slides);
    },

    getLayerDivElement: function() {
        var self = this;

        return self.wrapper;
    },

    updatePositions: function() {
        var elements = this.currentElements;
        var el;
        var view = this.currentView;

        if (elements) {
            var numberOfElements = elements.length;

            for (var i = 0; i < elements.length; i++) {
                el = elements[i];

                var mode = el[view] && el[view].mode ? el[view].mode : el.mode;
                if (mode == "content") continue;

                el = JSON.parse(JSON.stringify(elements[i]));
                el.node = elements[i].node;

                if (!el.node) continue;

                if (el[view]) {
                    for (var key in el[view]) {
                        el[key] = el[view][key];
                    }
                }

                this.updateNodeData(el);
            }
        }
        if (this.lightbox) this.lightbox.updateSize();
    },

    updateView: function(view) {
        var elements = this.currentElements;
        var index = this.currentIndex;

        this.currentView = view;
        var el;
        var pos;

        if (elements) {
            var numberOfElements = elements.length;

            for (var i = 0; i < elements.length; i++) {
                el = JSON.parse(JSON.stringify(elements[i]));
                el.node = elements[i].node;

                if (!el.node) continue;

                if (el[view]) {
                    for (var key in el[view]) {
                        el[key] = el[view][key];
                    }
                }

                pos = el.position || {};
                pos.x = pos.x || "center";
                pos.y = pos.y || "center";

                var $container = el.mode === "content" ? this.slides[index].$wrapper.find(".row-" + pos.y).find(".col-" + pos.x) : this.slides[index].$canvas;

                if (el.parent) {
                    this.$wrapper.find("#" + el.parent).append(jQuery(el.node));
                } else if (el.node.wrapper) {
                    el.node.wrapper.append(jQuery(el.node));
                    $container.append(jQuery(el.node.wrapper));
                } else {
                    $container.append(jQuery(el.node));
                }

                this.updateNodeData(el);

                jQuery(el.node)
                    .removeClass("tablet mobile")
                    .addClass(view);
            }
        }
    }
};


STX.Buttons = function(options) {
    var self = this;

    self.ev = options.ev;
    self.muteVisible = options.buttons.muteVisible;
    self.pauseVisible = options.buttons.pauseVisible;

    self.muted = true;
    self.paused = !options.videoAutoplay;

    self.$buttonsWrapper = jQuery('<div class="stx-buttons-wrapper">\n' + '<div class="stx-pause">\n' + '<i class="stx-fas stx-fa-pause"></i>\n' + "</div>\n" + '<div class="stx-unmute">\n' + '<i class="stx-fas stx-fa-volume-off"></i>\n' + '<div class="stx-unmute-text"></div>\n' + "</div>\n" + "</div>");
    self.$unmuteButton = self.$buttonsWrapper.find(".stx-unmute");
    self.$pauseButton = self.$buttonsWrapper.find(".stx-pause");

    setupButtonsEventListeners();
    self.hideButtonsWrapper();

    function setupButtonsEventListeners() {
        var text = "";

        function checkPlayButtonState() {
            if (self.paused) {
                self.$pauseButton
                    .find(".stx-fas")
                    .removeClass("stx-fas stx-fa-pause")
                    .addClass("stx-fas stx-fa-play");
            } else {
                self.$pauseButton
                    .find(".stx-fas")
                    .removeClass("stx-fas stx-fa-play")
                    .addClass("stx-fas stx-fa-pause");
            }
        }

        self.$unmuteButton.click(function() {
            text = STX.Utils.isMobileDevice() ? "TAP" : "CLICK";
            self.muted = !self.muted;
            if (self.muted) {
                text += " TO UNMUTE";
                jQuery(this)
                    .find(".stx-fas")
                    .removeClass("stx-fas stx-fa-volume-up")
                    .addClass("stx-fas stx-fa-volume-off");
            } else {
                text += " TO MUTE";
                jQuery(this)
                    .find(".stx-fas")
                    .removeClass("stx-fas stx-fa-volume-off")
                    .addClass("stx-fas stx-fa-volume-up");
            }
            jQuery(".stx-unmute-text").text(text);
            self.ev.trigger("onMuteButtonUpdate", [self.muted]);
        });

        self.$pauseButton.click(function() {
            self.paused = !self.paused;
            checkPlayButtonState();
            self.ev.trigger("onPauseButtonUpdate", [self.paused]);
        });

        checkPlayButtonState();

        self.ev.on("showVideoButtons", function() {
            self.showButtonsWrapper();
        });
        self.ev.on("hideVideoButtons", function() {
            self.hideButtonsWrapper();
        });
    }
};

STX.Buttons.prototype = {
    hideButtonsWrapper: function() {
        var self = this;

        self.$buttonsWrapper.fadeOut(300, function() {
            if (!self.muteVisible) self.$unmuteButton.hide();
            if (!self.pauseVisible) self.$pauseButton.hide();
            self.$buttonsWrapper.hide();
        });
    },

    showButtonsWrapper: function() {
        var self = this;

        self.ev.trigger("onMuteButtonUpdate", [self.muted]);
        self.ev.trigger("onPauseButtonUpdate", [self.paused]);
        var text = STX.Utils.isMobileDevice() ? "TAP" : "CLICK";
        text += self.muted ? " TO UNMUTE" : " TO MUTE";
        jQuery(".stx-unmute-text").text(text);

        self.$buttonsWrapper.fadeIn(300, function() {
            if (self.muteVisible) self.$unmuteButton.show();
            if (self.pauseVisible) self.$pauseButton.show();
            self.$buttonsWrapper.show();
        });
    },

    getUnmuteDivElement: function() {
        var self = this;

        return self.$buttonsWrapper;
    }
};


STX.Utils = {
    checkForSupportedMediaType: function(url) {
        var mediaType;
        var mediaExtension;

        mediaExtension = new RegExp("\\.\\w{3,4}($|\\?)", "g").exec(url)[0];

        for (var supportedMediaType in STX.Utils.supportedMediaTypes) {
            if (STX.Utils.supportedMediaTypes[supportedMediaType].includes(mediaExtension)) {
                mediaType = supportedMediaType;
                break;
            }
            mediaType = STX.Utils.supportedMediaTypes.NOT_SUPPORTED;
        }

        return {
            mediaType: mediaType,
            mediaExtension: mediaExtension
        };
    },

    checkForURLProtocol: function(url) {
        return url.includes(window.location.hostname) ? url.replace(/https?:/i, window.location.protocol) : url;
    },

    isMobileDevice: function() {
        return typeof window.orientation !== "undefined" || navigator.userAgent.indexOf("IEMobile") !== -1;
    },

    capitalize: function(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    },

    getRandomInt: function(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    },

    camelToDash: function(variableName) {
        return variableName.replace(/[A-Z]/g, function(letter) {
            return "-" + letter.toLowerCase();
        });
    },

    htmlToElement: function(html) {
        var template = document.createElement('template');
        html = html.trim();
        template.innerHTML = html;
        return template.content.firstChild;
    },

    transitionEffect: {
        SIMPLE_WAVE: "SimpleWave",
        ZOOM_IN: "ZoomIn",
        SIMPLE: "Simple",
        TWIRL: "Twirl",
        WARP: "Warp",
        ROLL_TOP_LEFT: "RollTopLeft",
        TEST: "Test",
        BLACK_FADE: "BlackFade",
        FLASH: "Flash",
        ROLL: "Roll"
    },

    supportedMediaTypes: {
        VIDEO: [".mp4", ".m4a", ".m4p", ".m4b", ".m4r", ".m4v", ".webm", ".ogg"],
        IMAGE: [".jpg", ".jpeg", ".png", ".bmp", ".webp"],
        NOT_SUPPORTED: "notSupported"
    },

    cssProperties:{

        width: 'width',
        height: 'height',
        margin: 'margin',
        padding: 'padding',

        paddingTop: 'padding-top',
        paddingBottom: 'padding-bottom',
        paddingLeft: 'padding-left',
        paddingRight: 'padding-right',

        marginTop: 'margin-top',
        marginBottom: 'margin-bottom',
        marginLeft: 'margin-left',
        marginRight: 'margin-right',

        fontFamily: 'font-family',
        fontSize: 'font-size',
        fontWeight: 'font-weight',

        lineHeight: 'line-height',
        letterSpacing: 'letter-spacing',
        textAlign: 'text-align',
        backgroundColor: 'background-color',

        borderWidth: 'border-width',
        borderStyle: 'border-style',
        borderColor: 'border-color',
        borderRadius: 'border-radius',

        textColor: 'color',

        minWidth: 'min-width',
        maxWidth: 'max-width'
    },

    iOS: function() {
      return [
        'iPad Simulator',
        'iPhone Simulator',
        'iPod Simulator',
        'iPad',
        'iPhone',
        'iPod'
      ].includes(navigator.platform)
      || (navigator.userAgent.includes("Mac") && "ontouchend" in document)
    }


};
