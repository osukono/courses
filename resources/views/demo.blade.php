<div id="player-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <course-player
                translations="{{ json_encode($translations) }}"
                encoded-locale="{{ json_encode($locale) }}"
            >
            </course-player>
        </div>
    </div>
</div>
