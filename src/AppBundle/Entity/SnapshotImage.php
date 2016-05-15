<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;

/**
 * SnapshotImage
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SnapshotImageRepository")
 *
 * @Vich\Uploadable
 */
class SnapshotImage
{
    public static $imageSizes = [
        ['width' => 1920, 'height' => '1080'],
        ['width' => 1366, 'height' => '768'],
        ['width' => 736, 'height' => '414'],
        ['width' => 640, 'height' => '360']
    ];
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="snapshot_image", fileNameProperty="imageName")
     * @var File $imageFile
     */
    protected $imageFile;

    /**
     * @ORM\Column(type="string", length=255, name="image_name")
     *
     * @var string $imageName
     */
    protected $imageName;

    /**
     * @var integer
     *
     * @ORM\Column(name="width", type="smallint", nullable=true)
     */
    private $width;

    /**
     * @var integer
     *
     * @ORM\Column(name="height", type="smallint", nullable=true)
     */
    private $height;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="Snapshot", inversedBy="images")
     * @ORM\JoinColumn(name="snapshot_id", referencedColumnName="id")
     **/
    private $snapshot;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return SnapshotImage
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return SnapshotImage
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set snapshot
     *
     * @param \AppBundle\Entity\Snapshot $snapshot
     * @return SnapshotImage
     */
    public function setSnapshot(\AppBundle\Entity\Snapshot $snapshot = null)
    {
        $this->snapshot = $snapshot;

        return $this;
    }

    /**
     * Get snapshot
     *
     * @return \AppBundle\Entity\Snapshot 
     */
    public function getSnapshot()
    {
        return $this->snapshot;
    }

    /**
     * Set width
     *
     * @param integer $width
     * @return SnapshotImage
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return SnapshotImage
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer 
     */
    public function getHeight()
    {
        return $this->height;
    }

    public function setImageFileFromBase64Data($imageData)
    {
        /*
         * The Vich Uploader requires a UploadedFile to be passed into it for it to work
         * As a result we need to create one from our base64 data
         */
        $imageData = base64_decode($imageData);
        $imageTempName = md5($imageData) . uniqid();
        $imageTempLocation = sys_get_temp_dir() . '/' . $imageTempName;
        file_put_contents($imageTempLocation, $imageData);

        $mimetype = MimeTypeGuesser::getInstance()->guess($imageTempLocation);
        $size = filesize($imageTempLocation);

        $file = new UploadedFile($imageTempLocation, $imageTempName, $mimetype, $size, null, true);
        $this->setImageFile($file);
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }
}
