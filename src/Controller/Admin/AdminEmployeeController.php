<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use App\Form\AdminEmployeeType;
use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employee')]
class AdminEmployeeController extends AbstractController
{
    #[Route('/', name: 'app_admin_employee_index', methods: ['GET'])]
    public function index(EmployeeRepository $employeeRepository): Response
    {
        return $this->render('admin/admin_employee/index.html.twig', [
            'employees' => $employeeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_employee_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmployeeRepository $employeeRepository): Response
    {
        $employee = new Employee();
        $form = $this->createForm(AdminEmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeRepository->save($employee, true);

            return $this->redirectToRoute('app_admin_employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_employee/new.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_employee_show', methods: ['GET'])]
    public function show(Employee $employee): Response
    {
        return $this->render('/admin/admin_employee/show.html.twig', [
            'employee' => $employee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_employee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Employee $employee, EmployeeRepository $employeeRepository): Response
    {
        $form = $this->createForm(AdminEmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeRepository->save($employee, true);

            return $this->redirectToRoute('app_admin_employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_employee/edit.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_employee_delete', methods: ['POST'])]
    public function delete(Request $request, Employee $employee, EmployeeRepository $employeeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $employee->getId(), $request->request->get('_token'))) {
            $employeeRepository->remove($employee, true);
        }

        return $this->redirectToRoute('app_admin_employee_index', [], Response::HTTP_SEE_OTHER);
    }
}
