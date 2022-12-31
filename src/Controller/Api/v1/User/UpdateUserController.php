<?php

namespace App\Controller\Api\v1\User;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Requests\UpdateUserRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use OpenApi\Annotations as OA;

#[Route('/api/v1', name: 'api_vi_')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class UpdateUserController extends AbstractController
{
    #[Route('/users/{id}', name: 'update_user', requirements: ['id' => '\d+'], methods: 'PUT')]
    /**
     * @OA\Put(
     *     summary="Update user",
     *     description="Update user. The administrator can update the data of any user",
     * )
     * @OA\RequestBody(
     *     required=true,
     *     description="User data",
     *     @OA\JsonContent(
     *       @OA\Property(property="firstName", type="string", format="text", example="dima"),
     *       @OA\Property(property="lastName", type="string", format="text", example="mon"),
     *       @OA\Property(property="email", type="email", format="text", example="user@example.com"),
     *       @OA\Property(property="phone", type="string", format="text", example="+77755522"),
     *    ),
     * )
     * @OA\Parameter(
     *      in="path",
     *      name="id",
     *      required=true,
     *      description="User ID to update",
     * ),
     * @OA\Response(
     *     response=200,
     *     description="New user successfully created",
     * )
     * @OA\Response(
     *     response=400,
     *     description="There was a validation error",
     *     @OA\JsonContent(
     *       @OA\Property(property="errors", type="object", example={
     *              "property":"firstName",
     *              "value": "d",
     *              "message": "Your first name must be at least 2 characters long"
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
    public function update(UserRepository $userRepository, User $user, Request $request, UpdateUserRequest $profileRequest): JsonResponse
    {
        if ($user === $this->getUser() or $this->isGranted('ROLE_ADMIN') === true) {
            $data = json_decode($request->getContent());
            $userRepository->update($user, $data);
            return $this->json(['message' => 'Update successful']);
        }

        return $this->json([
            "code" => 403,
            'message' => 'Forbidden'
        ], 403);

    }
}
