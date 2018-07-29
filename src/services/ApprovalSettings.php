<?php

namespace EC_PublishApproval;

class ApprovalSettings
{
	const OPTION_NAME = 'ec_publish_approval_options';

	private static $options;

	public static function updateOptions($options)
	{
		update_option(self::OPTION_NAME, $options);
	}

	public static function getForType($postType)
	{
		$options = self::getOptions();
		if (isset($options[$postType])) {
			return $options[$postType];
		}

		return [
			'enabled' => false,
			'editors' => [],
			'requiredApprovals' => 0
		];
	}

	private static function getOptions()
	{
		if (!self::$options) {
			self::$options = get_option(self::OPTION_NAME, []);
		}

		return self::$options;
	}

	public static function createSettings($enabled, $editorIds, $requiredApprovals)
	{
		return [
			'enabled' => (bool)$enabled,
			'editors' => array_unique(array_filter(array_map('intval', $editorIds))),
			'requiredApprovals' => max(1, min(100, intval($requiredApprovals)))
		];
	}
}

/*

Options format:

{
	<post-type>:
		enabled: bool,
		editors:  userId[],
		requiredApprovals: int
}

 */