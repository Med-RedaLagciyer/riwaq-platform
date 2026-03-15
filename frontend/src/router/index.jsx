import { createBrowserRouter } from 'react-router-dom'
import ProtectedRoute from '../components/routing/ProtectedRoute'
import GuestRoute from '../components/routing/GuestRoute'
import RegisterPage from '../pages/auth/register/RegisterPage'
import LoginPage from '../pages/auth/login/LoginPage'
import VerifyEmailPage from '../pages/auth/verify-email/VerifyEmailPage'
import CompleteRegistrationPage from '../pages/auth/complete-registration/CompleteRegistrationPage'
import AnimatedRoutes from '../components/routing/AnimatedRoutes'

const router = createBrowserRouter([
    {
        element: <AnimatedRoutes />,
        children: [
            {
                path: '/',
                element: <div>Landing Page</div>,
            },
            {
                path: '/login',
                element: (
                    <GuestRoute>
                        <LoginPage />
                    </GuestRoute>
                ),
            },
            {
                path: '/register',
                element: (
                    <GuestRoute>
                        <RegisterPage />
                    </GuestRoute>
                ),
            },
            {
                path: '/verify-email',
                element: (
                    <GuestRoute>
                        <VerifyEmailPage />
                    </GuestRoute>
                ),
            },
            {
                path: '/complete-registration',
                element: (
                    <GuestRoute>
                        <CompleteRegistrationPage />
                    </GuestRoute>
                ),
            },
            {
                path: '/student/dashboard',
                element: (
                    <ProtectedRoute allowedRoles={['ROLE_STUDENT']}>
                        <div>Student Dashboard</div>
                    </ProtectedRoute>
                ),
            },
            {
                path: '/professor/dashboard',
                element: (
                    <ProtectedRoute allowedRoles={['ROLE_PROFESSOR']}>
                        <div>Professor Dashboard</div>
                    </ProtectedRoute>
                ),
            },
            {
                path: '/management/dashboard',
                element: (
                    <ProtectedRoute allowedRoles={['ROLE_ORG_MANAGER', 'ROLE_STAFF']}>
                        <div>Management Dashboard</div>
                    </ProtectedRoute>
                ),
            },
            {
                path: '/unauthorized',
                element: <div>403 - You do not have permission to access this page</div>,
            },
            {
                path: '*',
                element: <div>404 - Page Not Found</div>,
            },
        ],
    },
])

export default router