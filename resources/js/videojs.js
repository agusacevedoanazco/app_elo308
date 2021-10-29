//videojs modules
import videojs from "video.js";
require('@silvermine/videojs-quality-selector')(videojs);
require('videojs-event-tracking');

//videojs initialization
const player = videojs('player',{
    fluid: true,
    autoplay: false,
    controls: true,
    playbackRates: [0.5, 1, 1.5, 2, 2.5],
    plugins: {
        eventTracking : true,
    }
});

//adding qualityselector (relative position 11 for quality selection)
player.controlBar.addChild('QualitySelector',{},11);

/**
 * Local dev Plausible
 */
import Plausible from "plausible-tracker";

const plausible = Plausible({
    domain: "localdev.lan",
    trackLocalhost: true,
    apiHost: "http://plausible.europa.lan"
});

var firstTime = true;
plausible.trackPageview();
player.on('tracking:firstplay', (e,data)=> {
        if (firstTime){
            plausible.trackEvent(
                'video-play',
                {
                    props : {
                        position : 'start'
                    }
                }
            );
            firstTime = false;
        }
    }
);
player.on('tracking:first-quarter',()=>{
    plausible.trackEvent(
        'video-play',
        {
            props : {
                position : 'reach-firstquarter',
            }
        }
    );
});
player.on('tracking:second-quarter',()=>{
    plausible.trackEvent(
        'video-play',
        {
            props : {
                position : 'reach-half',
            }
        }
    );
});
player.on('tracking:third-quarter',()=>{
    plausible.trackEvent(
        'video-play',
        {
            props : {
                position : 'reach-thirdquarter',
            }
        }
    );
});
player.on('tracking:fourth-quarter',()=>{
    plausible.trackEvent(
        'video-play',
        {
            props : {
                position : 'reach-end',
            }
        }
    );
});
