<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
#[UniqueEntity(fields: ['email'], message: 'Un compte existe déjà avec cet email')]
#[UniqueEntity(fields: ['username'], message: 'Ce nom d\'utilisateur est déjà pris')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Le nom d\'utilisateur est obligatoire')]
    #[Assert\Length(
        min: 3,
        max: 180,
        minMessage: 'Le nom d\'utilisateur doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Le nom d\'utilisateur ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $username = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank(message: 'L\'email est obligatoire')]
    #[Assert\Email(message: 'L\'email {{ value }} n\'est pas valide')]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    private ?string $password = null;

    #[ORM\Column(type: 'integer', options: ['default' => 1000])]
    private int $coins = 1000;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private int $totalGames = 0;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private int $totalWins = 0;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private int $totalScore = 0;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->coins = 1000;
        $this->totalGames = 0;
        $this->totalWins = 0;
        $this->totalScore = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCoins(): int
    {
        return $this->coins;
    }

    public function setCoins(int $coins): self
    {
        $this->coins = $coins;
        return $this;
    }

    public function addCoins(int $amount): self
    {
        $this->coins += $amount;
        return $this;
    }

    public function removeCoins(int $amount): self
    {
        $this->coins -= $amount;
        if ($this->coins < 0) {
            $this->coins = 0;
        }
        return $this;
    }

    public function getTotalGames(): int
    {
        return $this->totalGames;
    }

    public function setTotalGames(int $totalGames): self
    {
        $this->totalGames = $totalGames;
        return $this;
    }

    public function incrementTotalGames(): self
    {
        $this->totalGames++;
        return $this;
    }

    public function getTotalWins(): int
    {
        return $this->totalWins;
    }

    public function setTotalWins(int $totalWins): self
    {
        $this->totalWins = $totalWins;
        return $this;
    }

    public function incrementTotalWins(): self
    {
        $this->totalWins++;
        return $this;
    }

    public function getTotalScore(): int
    {
        return $this->totalScore;
    }

    public function setTotalScore(int $totalScore): self
    {
        $this->totalScore = $totalScore;
        return $this;
    }

    public function addToTotalScore(int $score): self
    {
        $this->totalScore += $score;
        return $this;
    }

    public function getWinRate(): float
    {
        if ($this->totalGames === 0) {
            return 0;
        }
        return round(($this->totalWins / $this->totalGames) * 100, 2);
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}

