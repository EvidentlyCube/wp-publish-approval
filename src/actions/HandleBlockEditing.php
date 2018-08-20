<?php

namespace EC_PublishApproval;

class HandleBlockEditing
{
	public static function printNotifications()
	{
		if (ApprovalState::isEditingBlocked()) {
			echo '<div class="notice notice-warning is-dismissible"><p>';
			_e('This page cannot be edited because it is published.', 'publish-approval');
			echo '</p></div>';
		}
	}

	public static function makeTinyMceReadonly($args)
	{
		if (ApprovalState::isEditingBlocked()) {
			$args['readonly'] = 1;
		}

		return $args;
	}

	public static function makeCodeEditorReadonly($editorHtml)
	{
		if (ApprovalState::isEditingBlocked()) {
			return str_replace('<textarea ', '<textarea disabled ', $editorHtml);
		}

		return $editorHtml;
	}

	public static function stripUnsaveableData($data)
	{
		$oldPostStatus = PostHelpers::getPostStatus(ApprovalState::getPostId());

		if (ApprovalState::getIsAlreadyPublished()) {
			if (ApprovalState::isEditingBlocked() && !ApprovalState::canChangeStatus()) {
				$data = [
					'post_status' => $oldPostStatus
				];

			} else if (ApprovalState::isEditingBlocked()) {
				$data = [
					'post_status' => $data['post_status']
				];

			} else if (!ApprovalState::canChangeStatus()) {
				$data['post_status'] = $oldPostStatus;
			}
		}

		return $data;
	}
}