<?php


namespace EC_PublishApproval;


class AdminBodyClassHandler
{
	public static function addAdminClasses($classes)
	{
		if (!ApprovalState::getIsInValidContext() || !ApprovalState::isEnabled()) {
			return $classes;
		}

		$newClasses = [];

		if (!ApprovalState::getIsAlreadyPublished()) {
			if (ApprovalState::getCanApproveThisPost()) {
				$newClasses[] = 'ec-approval-available';
			}

			if (ApprovalState::getCanApproveThisType()) {
				$newClasses[] = 'ec-approval-type-available';
			}

			if (ApprovalState::hasEnoughApprovals()) {
				$newClasses[] = 'ec-approval-publishable';
			} else {
				$newClasses[] = 'ec-approval-not-publishable';
			}

		}

		if (!ApprovalState::canChangeStatus()) {
			$newClasses[] = 'ec-approval-status-change-blocked';
		}

		if (!ApprovalState::canChangeStatus() && ApprovalState::isEditingBlocked()) {
			$newClasses[] = 'ec-approval-save-blocked';
		}

		return $classes . ' ' . implode(' ', $newClasses);
	}
}