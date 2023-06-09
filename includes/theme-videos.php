<?php
function paperplane_theme_videos($field_names)
{
    if (is_string($field_names)) {
        $field_names = array($field_names);
    }
    if ($field_names) {
        //var_dump($field_names);
        foreach ($field_names as $field_name) {
            $videos_count = paperplane_random_code();
            $video_source = $field_name['video_source'];
            if ($video_source === 'youtube' || $video_source === 'vimeo') {
                $video_id = $field_name['video_id'];
                $video_cover = $field_name['video_cover']['sizes']['column'];
            }
            if ($video_source === 'upload-video') {
                $video_id = 'uploaded-video';
                $video_cover = $field_name['video_cover']['sizes']['column'];
            }
            ?>
            <div class="video-frame last-child-no-margin">
                <a href="#" id="play-video-<?php echo $videos_count; ?>" class="play-video-js video-cover"
                    data-video-toplay="video-<?php echo $videos_count; ?>" data-video-source="<?php echo $video_source; ?>"
                    data-youtube-video-id="<?php echo $video_id; ?>" title="<?php _e('Play video', 'paperPlane-blankTheme') ?>"
                    aria-label="<?php _e('Play video', 'paperPlane-blankTheme') ?>">
                    <img src="<?php echo $video_cover; ?>" title="<?php _e('Play video', 'paperPlane-blankTheme') ?>"
                        alt="<?php _e('Play video', 'paperPlane-blankTheme') ?>" decoding="async" loading="lazy" />
                </a>
                <?php if ($video_source === 'vimeo'): ?>
                    <iframe id="video-<?php echo $videos_count; ?>" class="video-stop-js"
                        data-video-source="<?php echo $video_source; ?>"
                        data-src="https://player.vimeo.com/video/<?php echo $video_id; ?>" loading="lazy" width="640" height="360"
                        allow="autoplay" mozallowfullscreen webkitallowfullscreen allowfullscreen
                        title="<?php _e('Guarda un video di AroundTheBlue', 'atb-theme') ?>"
                        aria-label="<?php _e('Guarda un video di AroundTheBlue', 'atb-theme') ?>"></iframe>
                <?php elseif ($video_source === 'youtube'): ?>
                    <div id="video-<?php echo $videos_count; ?>" class="video-stop-js" data-video-source="<?php echo $video_source; ?>"
                        data-youtube-video-id="<?php echo $video_id; ?>" data-video-tostop="video-<?php echo $videos_count; ?>">
                    </div>
                <?php elseif ($video_source === 'upload-video'): ?>
                    <video id="video-<?php echo $videos_count; ?>" class="video-stop-js"
                        data-video-source="<?php echo $video_source; ?>" preload="metadata" loading="lazy" controls>
                        <source type="video/mp4" src="<?php echo $field_name['video_file']; ?>">
                    </video>
                <?php endif; ?>
            </div>
            <?php
        }
    }
}