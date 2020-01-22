<?php


namespace App\Controller;

use App\Entity\Mark;
use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MarkController extends AbstractController
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
     * MarkController constructor.
     * @param $validator
     * @param $serializer
     * @param $request
     */
    public function __construct(
        ValidatorInterface $validator,
        SerializerInterface $serializer
    ) {
        $this->validator  = $validator;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/marks", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function addMarkToStudent(Request $request)
    {
        $dataMark          = $request->getContent();
        $entityManager     = $this->getDoctrine()->getManager();
        $studentRepository = $this->getDoctrine()->getRepository(Student::class);

        $mark = $this->serializer->deserialize($dataMark, 'App\Entity\Mark', 'json');

        if (empty($mark->getValue()) || empty($mark->getSubject()) || empty($mark->getStudentId())) {
            return $this->createResponse('Uncomplete data given. value, subject and studentId required', 500);
        }

        $validationErrors = $this->validator->validate($mark);

        if (count($validationErrors) > 0) {
            return $this->createResponse((string)$validationErrors, 500);
        }

        if (empty($studentRepository->find($mark->getStudentId()))) {
            return $this->createResponse('No existing student with id ' . $mark->getStudentId(), 500);
        }

        $entityManager->persist($mark);
        $entityManager->flush();

        return $this->createResponse('Mark added to student with id : ' . $mark->getId(), 200);
    }

    /**
     * @Route("/marks/student/{id}", methods={"GET"})
     * @param string $id
     * @return Response
     */
    public function getStudentAverage(string $id)
    {
        $studentRepository = $this->getDoctrine()->getRepository(Student::class);
        $response          = new Response();

        if (empty($id)) {
            $this->createResponse('No id given. Id required', 500);
        }

        if (empty($studentRepository->find($id))) {
            return $this->createResponse('No existing student with id ' . $id, 500);
        }

        $marks = $this->getDoctrine()
                      ->getRepository(Mark::class)
                      ->getAverageForStudent($id);

        if (empty($marks)) {
            return $this->createResponse('No marks found for student id ' . $id, 500);
        }

        $average = $this->getMarksAverage($marks);

        $return = [
            'average' => $average,
        ];

        $response->setContent(json_encode($return));
        $response->setStatusCode(200);

        return $response;
    }

    /**
     * @Route("/marks/students", methods={"GET"})
     */
    public function getClassroomAverage()
    {
        $marksRepository = $this->getDoctrine()->getRepository(Mark::class);
        $response        = new Response();

        $marks = $marksRepository->findAll();

        if (empty($marks)) {
            return $this->createResponse('No marks recorded', 500);
        }

        $average = $this->getMarksAverage($marks);

        $return = [
            'average' => $average,
        ];

        $response->setContent(json_encode($return));
        $response->setStatusCode(200);

        return $response;
    }

    /**
     * Create a simple response with just a message and a HTTP code
     *
     * @param string $message
     * @param int $code
     * @return Response
     */
    protected function createResponse(
        $message = '',
        $code = 200
    ) {
        $response = new Response();

        $return = [
            'message' => $message,
        ];

        $response->setContent(json_encode($return));
        $response->setStatusCode($code);

        return $response;
    }

    /**
     * Retrieve average for an array of marks
     *
     * @param array $marks
     * @return float|int
     */
    protected function getMarksAverage(array $marks)
    {
        $marksNumber = 0;
        $total       = 0;

        foreach ($marks as $mark) {
            $total += $mark->getValue();

            $marksNumber++;
        }

        return $total / $marksNumber;
    }
}
