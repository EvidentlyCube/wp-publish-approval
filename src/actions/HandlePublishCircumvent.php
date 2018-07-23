<?php

namespace EC_PublishApproval;

class HandlePublishCircumvent
{
	public static function filterPostData($data)
	{
		if ($data['post_status'] === 'publish') {
			if (!ApprovalState::hasEnoughApprovals()) {
				EcPluginNotifications::addError(__('Post cannot be published, not enough approvals.', 'publish-approval'));
				$data['post_status'] = 'draft';
			}
		}

		return $data;
	}
}