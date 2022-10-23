<?php

namespace App\EventSubscriber;

use App\Entity\Article;
use App\Entity\Thumbnail;
use App\Form\Admin\ThumbnailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

class EasyAdminSubscriber extends AbstractController implements EventSubscriberInterface 
{
    private $slugger;
    protected $request;

    public function __construct(SluggerInterface  $slugger, RequestStack $requestStack)
    {
        $this->slugger = $slugger;
        $this->request = $requestStack->getCurrentRequest();
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setArticlePost'],
        ];
    }

    public function setArticlePost(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();
        $titre = $entity->getTitre();
        $description = $entity->getDescription();
        $image = $entity->getImage();
        //dd($entity->getThumbnail());
        $titreThumb = $entity->getThumbnail()->getTitre();
        $descriptionThumb = $entity->getThumbnail()->getDescriptionThumb();
        $imageThumb = $entity->getThumbnail()->getImage();
    
        if (!($entity instanceof Article)) {
            return;
        }
        
        if (empty($titreThumb) || empty($imageThumb)){
            $entity->setThumbnail($entity->getThumbnail()->setTitre($titre));
            $entity->setThumbnail($entity->getThumbnail()->setDescriptionThumb(substr(strip_tags($description),0,250)));
            $entity->setThumbnail($entity->getThumbnail()->setImage($image));

        }else{
            //dd($this->request->request->all());
            $thumbnail = new Thumbnail;
            $data = $this->request->request->all();
            $form = $this->createForm(ThumbnailType::class, $thumbnail);
            $form->handleRequest($this->request);
            dd($form->handleRequest($this->request));
            
            if ($image) {
                $filename = pathinfo($image);
                $originalFilename = $filename['filename'];
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$filename['extension'];
                //dd($newFilename);
                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('thumbnail_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $entity->setThumbnail($entity->getThumbnail()->setImage($newFilename));
            }
            
        }
        
    }
}