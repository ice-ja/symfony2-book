<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints As Assert;

/**
 * @ORM\Table(name="inquery")
 * @ORM\Entity(repositoryClass="App\Repository\InquiryRepository")
 */
class Inquiry
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()1
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     * @Assert\Length(max=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Length(max=20)
     * @Assert\Regex(pattern="/^[0-9-]+$/")
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(groups={"admin"})
     */
    private $processStatus;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(groups={"admin"})
     */
    private $processMemo;

    public function __construct()
    {
        $this->processStatus = 0;
        $this->processMemo = '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getProcessStatus(): ?string
    {
        return $this->processStatus;
    }

    public function setProcessStatus(string $processStatus): self
    {
        $this->processStatus = $processStatus;

        return $this;
    }

    public function getProcessMemo(): ?string
    {
        return $this->processMemo;
    }

    public function setProcessMemo(string $processMemo): self
    {
        $this->processMemo = $processMemo;

        return $this;
    }
}
