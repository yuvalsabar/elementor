jQuery(document).ready(function ($) {
    if (typeof wp.media !== "undefined") {
        var _custom_media = true,
            _orig_send_attachment = wp.media.editor.send.attachment;
        $(".new-media").click(function (e) {
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(this);
            var id = button.attr("id").replace("_button", "");
            _custom_media = true;
            wp.media.editor.send.attachment = function (props, attachment) {
                if (_custom_media) {
                    if ($("input#" + id).data("return") == "url") {
                        $("input#" + id).val(attachment.url);
                    } else {
                        $("input#" + id).val(attachment.id);
                    }
                    $("div.preview-" + id).css(
                        "background-image",
                        "url(" + attachment.url + ")"
                    );
                } else {
                    return _orig_send_attachment.apply(this, [
                        props,
                        attachment,
                    ]);
                }
            };
            wp.media.editor.open(button);
            return false;
        });

        $(".add_media").on("click", function () {
            _custom_media = false;
        });

        $(".remove-media").on("click", function () {
            var parent = $(this).parent();
            parent.find('input[type="text"]').val("");
            parent.find("div").css("background-image", "url()");
        });
    }
});
