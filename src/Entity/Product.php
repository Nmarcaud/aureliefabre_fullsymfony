<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PrePersist;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[HasLifecycleCallbacks]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\NotBlank(message: "Le nom du produit est obligatoire")]
    #[Assert\Length(min: 3, max: 255, minMessage: "Le nom du produit doit faire plus de 3 caractères")]
    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[Assert\NotBlank(message: "Le prix du produit est obligatoire")]
    #[Assert\Positive(message: "Le prix doit être positif !")]
    #[ORM\Column(type: 'integer', nullable: true)]
    private $price;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    private $category;

    // #[Assert\Url(message: "La photo principale doit être une URL valide")]
    // #[Assert\NotBlank(message: "La photo principale est obligatoire")]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $mainPicturePath;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: PurchaseItem::class)]
    private $purchaseItems;

    // #[Assert\NotBlank(message: "La descritpion est obligatoire")]
    // #[Assert\Length(min: 20, minMessage: "La description doit faire au moins 20 caractères")]
    #[ORM\Column(type: 'text', nullable: true)]
    private $shortDescription;

    #[ORM\Column(type: 'boolean')]
    private $isService;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $duration;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $turnaroundTime;

    #[ORM\Column(type: 'text', nullable: true)]
    private $fullDescription;

    #[ORM\Column(type: 'text', nullable: true)]
    private $warningText;

    #[ORM\Column(type: 'boolean')]
    private $isAvailableOnSite;

    #[ORM\Column(type: 'boolean')]
    private $isAvailableForAppointment;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $modifiedAt;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;


    public function __construct()
    {
        $this->purchaseItems = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    // CreatedAt Automatique
    #[ORM\PrePersist]
    public function setCreatedAtValue()
    {
        if(empty($this->createdAt)){
            $this->createdAt = new DateTime();
        }
    }

    // ModifiedAt Automatique
    #[ORM\PreUpdate]
    public function setModifiedAtValue()
    {
        if(empty($this->modifiedAt)){
            $this->modifiedAt = new DateTime();
        }
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getMainPicturePath(): ?string
    {
        return $this->mainPicturePath;
    }

    public function setMainPicturePath(?string $mainPicturePath): self
    {
        $this->mainPicturePath = $mainPicturePath;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * @return Collection|PurchaseItem[]
     */
    public function getPurchaseItems(): Collection
    {
        return $this->purchaseItems;
    }

    public function addPurchaseItem(PurchaseItem $purchaseItem): self
    {
        if (!$this->purchaseItems->contains($purchaseItem)) {
            $this->purchaseItems[] = $purchaseItem;
            $purchaseItem->setProduct($this);
        }

        return $this;
    }

    public function removePurchaseItem(PurchaseItem $purchaseItem): self
    {
        if ($this->purchaseItems->removeElement($purchaseItem)) {
            // set the owning side to null (unless already changed)
            if ($purchaseItem->getProduct() === $this) {
                $purchaseItem->setProduct(null);
            }
        }

        return $this;
    }

    public function getIsService(): ?bool
    {
        return $this->isService;
    }

    public function setIsService(bool $isService): self
    {
        $this->isService = $isService;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getTurnaroundTime(): ?int
    {
        return $this->turnaroundTime;
    }

    public function setTurnaroundTime(?int $turnaroundTime): self
    {
        $this->turnaroundTime = $turnaroundTime;

        return $this;
    }

    public function getFullDescription(): ?string
    {
        return $this->fullDescription;
    }

    public function setFullDescription(?string $fullDescription): self
    {
        $this->fullDescription = $fullDescription;

        return $this;
    }

    public function getWarningText(): ?string
    {
        return $this->warningText;
    }

    public function setWarningText(?string $warningText): self
    {
        $this->warningText = $warningText;

        return $this;
    }

    public function getIsAvailableOnSite(): ?bool
    {
        return $this->isAvailableOnSite;
    }

    public function setIsAvailableOnSite(bool $isAvailableOnSite): self
    {
        $this->isAvailableOnSite = $isAvailableOnSite;

        return $this;
    }

    public function getIsAvailableForAppointment(): ?bool
    {
        return $this->isAvailableForAppointment;
    }

    public function setIsAvailableForAppointment(bool $isAvailableForAppointment): self
    {
        $this->isAvailableForAppointment = $isAvailableForAppointment;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?\DateTimeInterface $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
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
