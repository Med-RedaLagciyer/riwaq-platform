import { useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { useForm } from 'react-hook-form'
import { zodResolver } from '@hookform/resolvers/zod'
import { useMutation } from '@tanstack/react-query'
import { resetPasswordSchema } from './resetPasswordSchema'
import { resetPassword } from '../../../services/authService'
import useAuthStore from '../../../store/useAuthStore'
import useToastStore from '../../../store/useToastStore'
import AuthLayout from '../../../layouts/auth/AuthLayout'
import PasswordInput from '../../../components/ui/PasswordInput/PasswordInput'
import './ResetPasswordPage.css'

export default function ResetPasswordPage() {
    const navigate = useNavigate()
    const temporaryToken = useAuthStore((state) => state.temporaryToken)
    const clearTemporaryToken = useAuthStore((state) => state.clearTemporaryToken)
    const clearPendingEmail = useAuthStore((state) => state.clearPendingEmail)
    const addToast = useToastStore((state) => state.addToast)

    useEffect(() => {
        if (!temporaryToken) {
            navigate('/forgot-password')
        }
    }, [])

    const { register, handleSubmit, formState: { errors } } = useForm({
        resolver: zodResolver(resetPasswordSchema),
    })

    const mutation = useMutation({
        mutationFn: resetPassword,
        onSuccess: () => {
            clearTemporaryToken()
            clearPendingEmail()
            addToast('Password reset successfully', 'success')
            navigate('/login')
        },
        onError: (error) => {
            addToast(error.response?.data?.message || 'Something went wrong', 'error')
        },
    })

    const onSubmit = (data) => {
        mutation.mutate({ ...data, temporaryToken })
    }

    return (
        <AuthLayout
            title="Reset your password"
            subtitle="Enter your new password below"
            showBack
            onBack={() => navigate('/verify-reset-code')}
        >
            <form className="auth-form" onSubmit={handleSubmit(onSubmit)}>
                <div className="form-group">
                    <div className="form-label">New password</div>
                    <PasswordInput
                        className={`form-input ${errors.password ? 'form-input--error' : ''}`}
                        placeholder="••••••••"
                        {...register('password')}
                    />
                    {errors.password && <span className="form-error">{errors.password.message}</span>}
                </div>
                <div className="form-group">
                    <div className="form-label">Confirm password</div>
                    <PasswordInput
                        className={`form-input ${errors.confirmPassword ? 'form-input--error' : ''}`}
                        placeholder="••••••••"
                        {...register('confirmPassword')}
                    />
                    {errors.confirmPassword && <span className="form-error">{errors.confirmPassword.message}</span>}
                </div>
                <button type="submit" className="primary-button" disabled={mutation.isPending}>
                    {mutation.isPending ? 'Resetting...' : 'Reset password'}
                </button>
            </form>
        </AuthLayout>
    )
}