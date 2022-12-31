<?php

namespace App\Controller\Api\v1\User;

use App\Repository\UserRepository;
use App\Requests\CreateUserRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/v1', name: 'api_v1_')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class CreateUserController extends AbstractController
{
    #[Route('/users', name: 'create_user', methods: 'POST')]
    /**
     * @OA\Post(
     *     summary="Create a new user",
     *     description="Create a new user. Only available for admin",
     * )
     * @OA\RequestBody(
     *     required=true,
     *     description="User data",
     *     @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="email", format="text", example="user@example.com"),
     *       @OA\Property(property="password", type="string", format="text", example="Password2022"),
     *    ),
     * )
     * @OA\Response(
     *     response=200,
     *     description="New user successfully created",
     * )
     * @OA\Response(
     *     response=400,
     *     description="There was a validation error",
     *     @OA\JsonContent(
     *       @OA\Property(property="errors", type="object", example={
     *              "property":"email",
     *              "value": "dima777",
     *              "message": "The email dima777 is not a valid email."
     *      }),
     *    ),
     * )
     * @OA\Response(
     *     response=401,
     *     description="JWT Token not found",
     * )
     * @OA\Response(
     *     response=403,
     *     description="Forbidden",
     * )
     */
    public function create(UserRepository $userRepository, Request $request, CreateUserRequest $createUserRequest): JsonResponse
    {
        if ($this->isGranted('ROLE_ADMIN') === false) {
            return $this->json([
                'code' => 403,
                'message' => 'Forbidden'
            ], 403);
        }

        $request = json_decode($request->getContent());
        $userRepository->create($request);
        return $this->json(['message' => 'New user successfully created']);
    }
}
