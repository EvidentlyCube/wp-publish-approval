<?php


namespace EC_PublishApproval;


class PostHelpers
{
	public static function getPostStatus($postId)
	{
		$previous_status = get_post_field('post_status', $postId);

		return $previous_status
			? $previous_status
			: 'new';
	}
}