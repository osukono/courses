<script>
    $(document).ready(function () {
        document.getElementById("audio").addEventListener('change', function (event) {
            let target = event.currentTarget;

            if (target.files.length > 0) {
                let file = target.files[0];
                let reader = new FileReader();
                reader.addEventListener('load', function () {

                    let data = reader.result;
                    // Create a Howler sound
                    let sound = new Howl({
                        src: data,
                        format: file.name.split('.').pop().toLowerCase(),
                    });

                    sound.once('load', function () {
                        let duration = sound.duration();
                        document.getElementById('duration').value = Math.trunc(duration * 1000);
                        document.getElementById('audio-duration').innerHTML = Math.trunc(duration * 1000) + " ms";

                        sound.unload();
                    });
                });
                reader.readAsDataURL(file);
            }
        }, false);
    });
</script>
