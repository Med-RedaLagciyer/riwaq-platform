import { useForm } from 'react-hook-form'
import { zodResolver } from '@hookform/resolvers/zod'
import { useMutation } from '@tanstack/react-query'
import { useNavigate } from 'react-router-dom'
import { forgotPasswordSchema } from './forgotPasswordSchema'
import { forgotPassword } from '../../../services/authService'
import useAuthStore from '../../../store/useAuthStore'
import useToastStore from '../../../store/useToastStore'
import AuthLayout from '../../../layouts/auth/AuthLayout'
import './ForgotPasswordPage.css'

export default function ForgotPasswordPage() {
    const navigate = useNavigate()
    const setPendingEmail = useAuthStore((state) => state.setPendingEmail)
    const addToast = useToastStore((state) => state.addToast)

    const { register, handleSubmit, formState: { errors } } = useForm({
        resolver: zodResolver(forgotPasswordSchema),
    })

    const mutation = useMutation({
        mutationFn: forgotPassword,
        onSuccess: (response, variables) => {
            setPendingEmail(variables.email)
            addToast('Check your email for the reset code', 'success')
            navigate('/verify-reset-code')
        },
        onError: (error) => {
            addToast(error.response?.data?.message || 'Something went wrong', 'error')
        },
    })

    const onSubmit = (data) => {
        mutation.mutate(data)
    }

    return (
        <AuthLayout
            title="Forgot your password?"
            subtitle="Enter your email and we'll send you a reset code"
            showBack
            onBack={() => navigate('/login')}
        >
            <form className="auth-form" onSubmit={handleSubmit(onSubmit)}>
                <div className="form-group">
                    <div className="form-label">Email address</div>
                    <input
                        type="text"
                        className={`form-input ${errors.email ? 'form-input--error' : ''}`}
                        placeholder="you@example.com"
                        {...register('email')}
                    />
                    {errors.email && <span className="form-error">{errors.email.message}</span>}
                </div>
                <button type="submit" className="primary-button" disabled={mutation.isPending}>
                    {mutation.isPending ? 
                        <span className="btn-loading">
                            <span />
                            <span />
                            <span />
                        </span>
                        : 'Send reset code'}
                </button>
            </form>
        </AuthLayout>
    )
}