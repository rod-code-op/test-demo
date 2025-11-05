<?php

namespace App\Controller;

use App\Entity\Rooms;
use App\Entity\Booking;
use App\Entity\CheckInOut;
use App\Form\RoomsType;
use App\Form\RoomFormType;
use App\Repository\RoomsRepository;
use App\Repository\BookingRepository;
use App\Repository\CheckInOutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
final class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(
        BookingRepository $bookingRepository,
        CheckInOutRepository $checkInOutRepository,
        RoomsRepository $roomsRepository
    ): Response {
        return $this->render('admin/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
            'checkInsOuts' => $checkInOutRepository->findAll(),
            'rooms' => $roomsRepository->findAll(),
        ]);
    }

    // --- CREATE NEW ROOM ---
    #[Route('/room/new', name: 'admin_room_new')]
    public function newRoom(Request $request, EntityManagerInterface $entityManager): Response
    {
        $room = new Rooms();
        $form = $this->createForm(RoomsType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($room);
            $entityManager->flush();

            $this->addFlash('success', sprintf('Room %s - added successfully!', $room->getRoomNumber()));


            // ✅ Stay on same page and reset form
            $room = new Rooms();
            $form = $this->createForm(RoomsType::class, $room);
        }

        return $this->render('admin/room_form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Add New Room',
        ]);
    }

    // --- EDIT EXISTING ROOM ---
    #[Route('/room/{id}/edit', name: 'admin_room_edit')]
    public function editRoom(Rooms $room, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RoomsType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', sprintf('Room %s - updated successfully!', $room->getRoomNumber()));
            return $this->redirectToRoute('app_admin_rooms');
        }

        return $this->render('admin/room_form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit Room',
        ]);
    }

    // --- DELETE ROOM ---
    #[Route('/room/{id}/delete', name: 'admin_room_delete', methods: ['POST', 'GET'])]
    public function deleteRoom(Rooms $room, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $room->getId(), $request->get('_token')) || $request->isMethod('GET')) {
            $entityManager->remove($room);
            $entityManager->flush();
            $this->addFlash('success', sprintf('Room %s - deleted successfully!', $room->getRoomNumber()));
        }

        // ✅ Stay on the rooms list
        return $this->redirectToRoute('app_admin_rooms');
    }

    // --- VIEW ALL ROOMS ---
    #[Route('/rooms', name: 'app_admin_rooms')]
    public function indexRooms(RoomsRepository $roomsRepository): Response
    {
        $rooms = $roomsRepository->findAll();

        return $this->render('admin/rooms_list.html.twig', [
            'rooms' => $rooms,
        ]);
    }
}
