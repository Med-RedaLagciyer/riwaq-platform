import { createBrowserRouter } from 'react-router-dom'
import ProtectedRoute from '../components/routing/ProtectedRoute'

const router = createBrowserRouter([
    {
        path: '/',
        element: <div>Landing Page</div>,
    },
    {
        path: '/login',
        element: <div>Login Page</div>,
    },
    {
        path: '/student/dashboard',
        element: (
            <ProtectedRoute allowedRoles={['student']}>
                <div>Student Dashboard</div>
            </ProtectedRoute>
        ),
    },
    {
        path: '/professor/dashboard',
        element: (
            <ProtectedRoute allowedRoles={['professor']}>
                <div>Professor Dashboard</div>
            </ProtectedRoute>
        ),
    },
    {
        path: '/management/dashboard',
        element: (
            <ProtectedRoute allowedRoles={['management']}>
                <div>Management Dashboard</div>
            </ProtectedRoute>
        ),
    },
    {
        path: '*',
        element: <div>404 - Page Not Found</div>,
    },
])

export default router