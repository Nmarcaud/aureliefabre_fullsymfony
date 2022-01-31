<?php

namespace App\Entity;

use DateTime;
use App\Entity\Category;
use App\Entity\MediaObject;
use App\Entity\PurchaseItem;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PrePersist;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ProductJpgImageController;
use App\Controller\ProductWebpImageController;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
#[ApiResource(
    itemOperations: [
        'put',
        'delete',
        'get',
        'image_jpg' => [
            'method' => 'POST',
            'path' => '/product/{id}/image/jpg',
            'deserialize' => false,
            'controller' => ProductJpgImageController::class,
            'openapi_context' => [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary'
                                    ]
                                ]
                            ]
                         ]
                    ]
                ]
            ]
        ],
        'image_webp' => [
            'method' => 'POST',
            'path' => '/product/{id}/image/webp',
            'deserialize' => false,
            'controller' => ProductWebpImageController::class,
            'openapi_context' => [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary'
                                    ]
                                ]
                            ]
                         ]
                    ]
                ]
            ]
        ]


    ],
    // collectionOperations: [
    //     'get',
    //     'post' => [
    //         'deserialize' => false,
    //         'input_formats' => [
    //             'multipart' => ['multipart/form-data'],
    //         ],
    //     ],
    // ],
)]
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


    // AJOUT D'IMAGES : Après 1 mois de galère...
    // Vidéo de Grafikart 
    // https://youtu.be/fhdD7K5nZSA

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="product_image_jpg", fileNameProperty="jpgName")
     */
    private $jpgPicture;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $jpgName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $jpgPicturePath;

    
    /**
     * @var File|null
     * @Vich\UploadableField(mapping="product_image_webp", fileNameProperty="webpName")
     */
    private $webpPicture;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $webpName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $webpPicturePath;

    /**
     * @ORM\ManyToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     */
    // #[ApiProperty(iri: 'http://schema.org/image')]
    // public ?MediaObject $image = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: PurchaseItem::class)]
    private $purchaseItems;

    #[ORM\Column(type: 'text', nullable: true)]
    private $shortDescription;

    #[ORM\Column(type: 'boolean')]
    private $isService;

    #[Assert\Positive(message: "Le temps doit être positif !")]
    #[ORM\Column(type: 'integer', nullable: true)]
    private $duration;

    #[Assert\Positive(message: "Le temps doit être positif !")]
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
        $this->modifiedAt = new DateTime();
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



    /**
     * @return File|null
     */
    public function getJpgPicture(): ?File
    {
        return $this->jpgPicture;
    }

    /**
     * @param File|null $jpgPicture
     * @return Product
     */
    public function setJpgPicture(?File $jpgPicture): Product
    {
        $this->jpgPicture = $jpgPicture;
        return $this;
    }

    public function getJpgName(): ?string
    {
        return $this->jpgName;
    }

    public function setJpgName(?string $jpgName): self
    {
        $this->jpgName = $jpgName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getJpgPicturePath(): ?string
    {
        return $this->jpgPicturePath;
    }

    /**
     * @param string|null $jpgPicture
     * @return Product
     */
    public function setJpgPicturePath(?string $jpgPicturePath): self
    {
        $this->jpgPicturePath = $jpgPicturePath;
        return $this;
    }



    /**
     * @return File|null
     */
    public function getWebpPicture(): ?File
    {
        return $this->webpPicture;
    }

    /**
     * @param File|null $webpPicture
     * @return Product
     */
    public function setWebpPicture(?File $webpPicture): Product
    {
        $this->webpPicture = $webpPicture;
        return $this;
    }

    public function getWebpName(): ?string
    {
        return $this->webpName;
    }

    public function setWebpName(?string $webpName): self
    {
        $this->webpName = $webpName;

        return $this;
    }

    public function getWebpPicturePath(): ?string
    {
        return $this->webpPicturePath;
    }

    public function setWebpPicturePath(?string $webpPicturePath): self
    {
        $this->webpPicturePath = $webpPicturePath;

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
