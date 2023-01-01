<?php

namespace App\Controller\Api\v1\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use OpenApi\Annotations as OA;

#[Route('/api/v1', name: 'api_vi_')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class ShowUserController extends AbstractController
{
    #[Route('/users', name: 'show_user', methods: 'GET')]
    /**
     * @OA\Get(
     *     summary="Show user",
     *     description="Show authorized user",
     * )
     * @OA\Response(
     *     response=200,
     *     description="Authenticated User Data",
     *     @OA\JsonContent(
     *           @OA\Property(
     *              property="data",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="number", example="1"),
     *                  @OA\Property(property="email", type="string", example="user@mail.com"),
     *                  @OA\Property(property="firstName", type="string", example="dima"),
     *                  @OA\Property(property="lastName", type="string", example="mov"),
     *                  @OA\Property(property="phone", type="string", example="+777555333"),
     *              )
     *          ),
     *        )
     *     )
     * )
     * @OA\Response(
     *     response=401,
     *     description="JWT Token not found",
     * )
     */
    public function show(): JsonResponse
    {
        $user = $this->getUser();
        $data = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'phone' => $user->getPhone(),
        ];
        return $this->json($data);
    }
}
