jQuery(document).ready(function () {
	initializeApprovalSettings(jQuery);
	disableEditorPageElements(jQuery);

	function initializeApprovalSettings($) {
		var $table = $('#publish-approval-settings');
		if ($table.length === 0) {
			return 0;
		}

		var $rowTemplate = $table.find('#users-template').remove();

		$table.find('.toggle-enable').on('click', onToggleEnableClick);
		$table.on('click', '.remove-editor-button', onRemoveEditorClick);
		$table.on('click', '.add-editor-button', onAddEditorClick);

		function onToggleEnableClick() {
			var $this = $(this);
			var $rows = $table.find($this.attr('data-selector'));

			if ($this.prop('checked')) {
				$rows.removeClass('hidden');
			} else {
				$rows.addClass('hidden');
			}
		}

		function onAddEditorClick() {
			e.preventDefault();
			e.stopPropagation();

			var $this = $(e.target);
			var name = $this.attr('data-name');
			var index = Date.now();
			var $newRow = $(
				'<tr class="subrow row-' + name + '">'
				+ $rowTemplate.html().replace(/%name%/g, name).replace(/%index%/g, index)
				+ '</tr>'
			);
			$this.parent().parent().before($newRow);
		}

		function onRemoveEditorClick() {
			e.preventDefault();
			e.stopPropagation();

			$(this).parent().parent().remove();

		}
	}

	function disableEditorPageElements($) {
		$('body.ec-approval-save-blocked #publishing-action input[type="submit"]').prop('disabled', true);
		$('body.ec-approval-status-change-blocked #misc-publishing-actions .edit-post-status').remove();
	}
});
