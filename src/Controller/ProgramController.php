<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/program", name="program_")
*/
class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()->getRepository(Program::class)->findAll();
        return $this->render('program/index.html.twig', ['programs' => $programs]);
    }

    /**
     * @route("/show/{id}/", methods={"GET"}, requirements={"id"="\d+"}, name="show")
     * @return Response
     */
    public function show(int $id): Response
    {
        $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy(['id' => $id]);

        $seasons = $this->getDoctrine()
        ->getRepository(Season::class)
        ->findBy(['program' => $id]);


        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        // var_dump($seasons);
        // dd($program);
        return $this->render('program/show.html.twig', ['program' => $program, 'seasons' => $seasons]);
    }

    /**
     * @route("/{programId}/seasons/{seasonId}", methods={"GET"}, requirements={"programId"="\d+"}, name="season_show")
     * @return Response
     */
    public function showSeason(int $programId, int $seasonId): Response
    {
        $seasons = $this->getDoctrine()
        ->getRepository(Season::class)
        ->findOneBy(['program' => $programId, 'id' => $seasonId]);

        if (!$seasons) {
            throw $this->createNotFoundException(
                'No season with id : '.$seasonId.' found in season\'s table.'
            );
        }
        // dd($seasons);
        return $this->render('seasons/season.html.twig', ['seasons' => $seasons]);
    }

}
