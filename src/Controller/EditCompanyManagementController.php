<?php

namespace App\Controller;

use App\Company\ApplicationService\DTO\CompanyRequest;
use App\Company\ApplicationService\UpdateCompany;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditCompanyManagementController extends AbstractController
{
    private UpdateCompany $updateCompany;

    public function __construct(UpdateCompany $updateCompany)
    {
        $this->updateCompany = $updateCompany;
    }

    /**
     * @Route("/company/management/edit/{id}", name="app_edit_company_management", methods={"POST"})
     */
    public function index($id, Request $request)
    {
        // return $this->render('edit_company/index.html.twig', [
        //     'controller_name' => 'EditCompanyController',
        // ]);

        $adminUser = $this->getUser();

        $company = $request->get('company');

        $companyRename = $company['name'];
        $companyId = $company['id'];

        var_dump($id);
        // var_dump( $company );

        var_dump( $companyRename );
        var_dump( $companyId );

        $companyRequest = new CompanyRequest(
            $companyRename,
            $companyId,
            $adminUser
        );

        $updateCompanyService = $this->updateCompany;

        $updateCompanyService->__invoke($companyRequest);


        return Response::create('???');
    }
}
