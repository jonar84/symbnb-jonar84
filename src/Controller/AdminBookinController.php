<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\AdminBookingType;
use App\Repository\BookingRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookinController extends AbstractController
{
    /**
     * Permet d'afficher la liste des reservations
     * @Route("/admin/bookin/{page<\d+>?1}", name="admin_booking_index")
     */
    public function index(PaginationService $pagination, $page, BookingRepository $repo): Response
    {
        $pagination->setEntityClass(Booking::class)
                   ->setPage($page);

        return $this->render('admin/booking/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet d'editer une reservation
     * @Route("/admin/bookings/{id}/edit", name="admin_booking_edit")
     * 
     */ 
    public function edit(Booking $booking, Request $request, EntityManagerInterface $manager) 
    {
        $form = $this->createForm(AdminBookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $booking->setAmount(0);
            $manager->persist($booking);
            $manager->flush();

            $this->addFlash(
                'success',
                "La reservation a bien éte modifiée"
            );

            return $this->redirectToRoute('admin_booking_index');
        }

        return $this->render('admin/booking/edit.html.twig', [
            'form' => $form->createView(),
            'booking' => $booking
        ]);
    } 


    /**
     * @Route("/admin/bookings/{id}/delete", name="admin_booking_delete")
     * 
     */
    public function delete(Booking $booking, EntityManagerInterface $manager)
    {
        $manager->remove($booking);
        $manager->flush();

        $this->addFlash(
            'success',
            "La reservation a bien été supprimée"
        );

        return $this->redirectToRoute("admin_booking_index");
    }
}
