<audio id="player"></audio>
<script type="text/javascript">
    function play(e) {
        stop();

        let player = $('#player');

        e.children().replaceWith(feather.icons.square.toSvg());
        e.attr('onclick', 'event.stopPropagation(); stop(); return false;');
        player[0].onended = function () {
            e.attr('onclick', 'event.stopPropagation(); play($(this)); return false;');
            e.children().replaceWith(feather.icons.play.toSvg());
            player[0].onended = null;
        };

        player.attr('src', e.attr('data-location'));
        player[0].load();
        player[0].oncanplaythrough = player[0].play();
    }

    function stop() {
        let player = $('#player');

        if (player[0].onended)
            player[0].onended();

        player[0].pause();
    }
</script>