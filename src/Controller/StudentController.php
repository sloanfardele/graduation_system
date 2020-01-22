<?php

namespace App\Controller;

use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class StudentController extends AbstractController
{

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * StudentController constructor.
     * @param $validator
     * @param $serializer
     */
    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->validator  = $validator;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/students/{id}", methods={"GET"})
     * @param string $id
     * @return Response
     */
    public function showStudent(string $id)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (empty($id)) {
            return $this->createResponse('Empty ID given, integer expected', 500);
        }

        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);

        if (!$student) {
            return $this->createResponse('No student founded for ID ' . $id, 500);
        }

        $validationErrors = $this->validator->validate($student);

        if (count($validationErrors) > 0) {
            return $this->createResponse((string)$validationErrors, 500);
        }

        $data = $this->serializer->serialize($student, 'json');

        $response->setContent($data);
        $response->setStatusCode(200);

        return $response;
    }

    /**
     * @Route("/students", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createStudent(Request $request)
    {
        $dataStudent   = $request->getContent();
        $entityManager = $this->getDoctrine()->getManager();

        $student = $this->serializer->deserialize($dataStudent, 'App\Entity\Student', 'json');

        if (empty($student->getLastName()) || empty($student->getFirstName()) || empty($student->getBirthDate())) {
            return $this->createResponse('Uncomplete data given. lastName, firstName and birthDate required', 500);
        }

        $entityManager->persist($student);
        $entityManager->flush();


        return $this->createResponse('New student save with id : ' . $student->getId(), 200);
    }

    /**
     * @Route("/students", methods={"PUT"})
     * @param Request $request
     * @return Response
     */
    public function editStudent(Request $request)
    {
        $dataRequestStudent = $request->getContent();
        $requestStudent     = json_decode($dataRequestStudent);
        $entityManager      = $this->getDoctrine()->getManager();

        if (empty($requestStudent->id)) {
            return $this->createResponse('No ID provided. ID needeed', 500);
        }

        $updatedStudent = $this->getDoctrine()->getRepository(Student::class)->find($requestStudent->id);


        if (empty($updatedStudent)) {
            return $this->createResponse('No student existing for id ' . $requestStudent->id, 500);
        }

        foreach ($requestStudent as $attr => $value) {
            if (method_exists($updatedStudent, 'set' . ucfirst($attr))
                && isset($value)
            ) {
                $setter = 'set' . ucfirst($attr);
                $updatedStudent->{$setter}($value);
            }
        }

        $entityManager->persist($updatedStudent);
        $entityManager->flush();

        return $this->createResponse('User ' . $updatedStudent->getId() . ' updated', 200);
    }


    /**
     * Create a simple response with just a message and a HTTP code
     *
     * @param string $message
     * @param int $code
     * @return Response
     */
    protected function createResponse($message = '', $code = 200)
    {
        $response = new Response();

        $return = [
            'message' => $message,
        ];

        $response->setContent(json_encode($return));
        $response->setStatusCode($code);

        return $response;
    }
}
