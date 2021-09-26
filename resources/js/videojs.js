import videojs from "video.js";
require('@silvermine/videojs-quality-selector')(videojs);

const player = videojs('player',{
    fluid: true,
    autoplay: false,
    controls: true,
    playbackRates: [0.5, 1, 1.5, 2, 2.5],
});

player.controlBar.addChild('QualitySelector',{},11);
