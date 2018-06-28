<?php
declare(strict_types=1);

namespace FTC\Discord\Model;

use FTC\Discord\Model\Collection\GuildRoleCollection;
use FTC\Discord\Model\ValueObject\Snowflake;

class GuildMember
{
    
    /**
     * @var User $user
     */
    private $user;
    
    /**
     * @var string $nickname?
     */
    private $nickname;
    
    /**
     * @var GuildRoleCollection $roles
     */
    private $roles;
    
    /**
     * @var \DateTime $joinedAt
     */
    private $joinedAt;
    
    private function __construct(User $user, string $nickname, GuildRoleCollection $roles = null)
    {
        $this->user = $user;
        $this->nickname = $nickname;
        $this->roles = $roles;
    }
    
    public function getnickname()
    {
        return $this->nickname;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function getRoles()
    {
        return $this->roles;
    }
    
    public static function register(User $user, string $nickname) : GuildMember
    {  
        $member = new GuildMember($user, $nickname);
        return $member;
    }
    
    public function toArray() : array
    {
        $roles = array_map(function($obj) { return $obj->toArray(); }, $this->roles->toArray());
        return [
            'user' => $this->user,
            'nickname' => $this->nickname,
            'roles' => $roles,
        ];
    }
    
    public static function fromDb(array $data) : GuildMember
    {
        $data['roles'] = json_decode($data['roles'], true);
        $data['roles'] = array_map([GuildRole::class, 'fromDbRow'], $data['roles']);
        $data['roles'] = new GuildRoleCollection(...$data['roles']);
        return new GuildMember(new Snowflake($data['user']), $data['nickname'], $data['roles']);
    }
    
}
