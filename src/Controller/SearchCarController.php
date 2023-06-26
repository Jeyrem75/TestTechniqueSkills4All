<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\CarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchCarController extends AbstractController
{
    #[Route('/search/car', name: 'app_search_car')]
    public function index(CarRepository $carRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $searchData->page = $request->query->getInt('page', 1);
            $cars = $carRepository->findBySearch($searchData);

            return $this->render('search_car/index.html.twig', [
                'form' => $form->createView(),
                'cars' => $cars
            ]);
        }

        $data = $carRepository->findAll();

        $cars = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('search_car/index.html.twig', [
            'form' => $form->createView(),
            'cars' => $cars
        ]);        
    }
}
