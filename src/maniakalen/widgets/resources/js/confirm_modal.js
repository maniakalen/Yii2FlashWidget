if (typeof jQuery === 'undefined') {
    alert("jQuery not loaded");
}
var jqr = jQuery;
confirmModal = function(outerconfig) {
    return jqr.Deferred(function(def) {
        (function(config) {
            config = jqr.extend({}, {
                "title" : "Confirm an action",
                "content" : "Are you sure you want to proceed with this action?",
                "titleOk" : "Yes",
                "titleCancel" : "No"
            }, config);
            if (typeof config.id === 'undefined') {
                return false;
            }
            var $dom = jqr('#' + config.id);
            if ($dom.length === 0) {
                $dom = jqr('<div/>').attr('id', config.id);
                $dom.addClass('modal confirm-modal');
                $dom.appendTo(jqr('body'));
            }
            $dom.modal({'backdrop' : true, 'show': false});
            var html  = '<div class="modal-dialog" role="document">';
            html += 	'<div class="modal-content">';
            html += 		'<div class="modal-header">';
            html += 			'<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
            html += 				'<span aria-hidden="true">&times;</span>';
            html += 			'</button>';
            html += 			'<h4 class="modal-title" id="myModalLabel">' + config.title + '</h4>';
            html += 		'</div>';
            html += 		'<div class="modal-body">' + config.content + '</div>';
            html += 		'<div class="modal-footer">';
            html +=         '<a href="#" class="btn btn-success" id="button-ok" data-dismiss="modal">' + config.titleOk + '</a>';
            html +=         '<a href="#" class="btn btn-danger" id="button-cancel" data-dismiss="modal" >' + config.titleCancel + '</a>';
            html +=         '</div>';
            html += 	'</div>';
            html += '</div>';
            $dom.html(html);

            jqr('a#button-ok', $dom).on('click', function() {
                def.resolve();
            });
            jqr('a#button-cancel', $dom).on('click', function() {
                def.reject();
            });

            $dom.modal('show');
        })(outerconfig);
    });
};