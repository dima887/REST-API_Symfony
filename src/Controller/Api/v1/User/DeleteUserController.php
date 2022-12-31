<?php

namespace App\Controller\Api\v1\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/v1', name: 'api_v1_')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class DeleteUserController extends AbstractController
{
    #[Route('/users/{id}', name: 'delete_user', requirements: ['id' => '\d+'], methods: 'DELETE')]
    /**
     * @OA\Delete(
     *     summary="Delete User",
     *     description="Delete User. Only available for admin",
     * )
     * @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         description="ID of user to delete",
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="User deleted successfully",
     * )
     * @OA\Response(
     *     response=401,
     *     description="JWT Token not found",
     * )
     * @OA\Response(
     *     response=403,
     *     description="Forbidden",
     * )
     * @OA\Response(
     *     response=404,
     *     description="Not Found",
     * )
     */
    public function delete(UserRepository $userRepository, User $user): JsonResponse
    {
        if ($this->isGranted('ROLE_ADMIN') === false) {
            return $this->json([
                'code' => 403,
                'message' => 'Forbidden'
            ], 403);
        }

        $userRepository->remove($user, true);
        return $this->json(['message' => 'User deleted successfully']);
    }
}
