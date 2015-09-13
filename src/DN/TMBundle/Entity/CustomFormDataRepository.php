<?php

namespace DN\TMBundle\Entity;

use Doctrine\ORM\EntityRepository;
use DN\TMBundle\Entity\CustomFormData;

class CustomFormDataRepository extends EntityRepository {

    public function saveForm($data, $formType) {
        $cfd = new CustomFormData();

        $cfd->setData(json_encode($data));
        $cfd->setCreated(new \DateTime('now'));
        $cfd->setFormType($formType);

        if (isset($data['email'])) {
            $cfd->setEmail($data['email']);
        }

        $this->getEntityManager()->persist($cfd);
        $this->getEntityManager()->flush();

        return true;
    }

}
