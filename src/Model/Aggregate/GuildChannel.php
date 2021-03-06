<?php
namespace FTC\Discord\Model\Aggregate;

use FTC\Discord\Model\ValueObject\Snowflake\ChannelId;

abstract class GuildChannel
{
    const GUILD_TEXT = 0;
    const DM = 1;
    const GUILD_VOICE = 2;
    const GROUP_DM = 3;
    const GUILD_CATEGORY = 4;
    
    /**
     * @var ChannelId $id
     */
    private $id;
    
    
    protected function __construct(ChannelId $id)
    {
        $this->id = $id;
    }
    
    public function getTypeId() : int
    {
        return $this->typeId;
    }
    
    public function getId() : ChannelId
    {
        return $this->id;
    }
    
}
