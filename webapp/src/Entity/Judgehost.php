<?php declare(strict_types=1);
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Hostnames of the autojudgers.
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="judgehost",
 *     options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4", "comment"="Hostnames of the autojudgers"},
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="hostname", columns={"hostname"})
 *     })
 * )
 */
class Judgehost
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="judgehostid", length=4,
     *     options={"comment"="Judgehost ID","unsigned"=true},
     *     nullable=false)
     * @Serializer\SerializedName("id")
     * @Serializer\Type("string")
     */
    private $judgehostid;

    /**
     * @var string
     * @ORM\Column(type="string", name="hostname", length=64, options={"comment"="Resolvable hostname of judgehost"}, nullable=false)
     * @Assert\Regex("/^[A-Za-z0-9_\-.]*$/", message="Invalid hostname. Only characters in [A-Za-z0-9_\-.] are allowed.")
     */
    private $hostname;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", name="active",
     *     options={"comment"="Should this host take on judgings?",
     *              "default"="1"},
     *     nullable=false)
     */
    private $active = true;

    /**
     * @var double
     * @ORM\Column(type="decimal", precision=32, scale=9, name="polltime",
     *     options={"comment"="Time of last poll by autojudger",
     *              "unsigned"=true},
     *     nullable=true)
     */
    private $polltime;

    /**
     * @ORM\OneToMany(targetEntity="JudgeTask", mappedBy="judgehost")
     * @Serializer\Exclude()
     */
    private $judgetasks;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", name="hidden",
     *     options={"comment"="Should this host be hidden in the overview?",
     *              "default"="0"},
     *     nullable=false)
     */
    private $hidden = false;

    public function __construct()
    {
        $this->judgetasks = new ArrayCollection();
    }

    public function getJudgehostid(): int
    {
        return $this->judgehostid;
    }

    public function setHostname(string $hostname): Judgehost
    {
        $this->hostname = $hostname;
        return $this;
    }

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function getShortDescription(): string
    {
        return $this->getHostname();
    }

    public function setActive(bool $active): Judgehost
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    /** @param string|float $polltime */
    public function setPolltime($polltime): Judgehost
    {
        $this->polltime = $polltime;
        return $this;
    }

    /** @return string|float */
    public function getPolltime()
    {
        return $this->polltime;
    }

    public function addJudgeTask(JudgeTask $judgeTask): Judgehost
    {
        $this->judgetasks[] = $judgeTask;
        return $this;
    }

    public function removeJudgeTask(JudgeTask $judgeTask)
    {
        $this->judgetasks->removeElement($judgeTask);
    }

    public function getJudgeTasks(): Collection
    {
        return $this->judgetasks;
    }

    public function setHidden(bool $hidden): Judgehost
    {
        $this->hidden = $hidden;
        return $this;
    }

    public function getHidden(): bool
    {
        return $this->hidden;
    }
}
