import { useForm } from 'react-hook-form'
import { zodResolver } from '@hookform/resolvers/zod'
import { useMutation } from '@tanstack/react-query'
import { useNavigate } from 'react-router-dom'
import { registerSchema } from './registerSchema'
import { registerUser } from '../../../services/authService'
import useAuthStore from '../../../store/useAuthStore'
import AuthLayout from '../../../layouts/auth/AuthLayout'
import './RegisterPage.css'
import useToastStore from '../../../store/useToastStore'

export default function RegisterPage() {
    const addToast = useToastStore((state) => state.addToast)
    const setTemporaryToken = useAuthStore((state) => state.setTemporaryToken)

    const { register, handleSubmit, formState: { errors } } = useForm({
        resolver: zodResolver(registerSchema),
    })

    const navigate = useNavigate()
    const setPendingEmail = useAuthStore((state) => state.setPendingEmail)

    const mutation = useMutation({
        mutationFn: registerUser,
        onSuccess: (response, variables) => {
            const message = response.data.message

            if (message === 'complete_registration') {
                setTemporaryToken(response.data.temporary_token)
                addToast('Continue completing your registration', 'info')
                navigate('/complete-registration')
                return
            }

            if (message === 'account_exists') {
                addToast('You already have an account, please login', 'info')
                navigate('/login')
                return
            }

            setPendingEmail(variables.email)
            navigate('/verify-email')
        },
        onError: (error) => {
            addToast(error.response?.data?.message || 'Something went wrong', 'error')
        },
    })

    const onSubmit = (data) => {
        mutation.mutate(data)
    }

    return (
        <AuthLayout title="Create your account" subtitle="Enter your email to get started">
            <form className='auth-form' onSubmit={handleSubmit(onSubmit)}>
                <div className='form-group'>
                    <div className="form-label">Email address</div>
                    <input
                        type="text"
                        className={`form-input ${errors.email ? 'form-input--error' : ''}`}
                        placeholder="Email address"
                        {...register('email')}
                    />
                    {errors.email && (
                        <span className="form-error">{errors.email.message}</span>
                    )}
                </div>
                <button type="submit" className="primary-button" disabled={mutation.isPending}>
                    {mutation.isPending ? 'Sending...' : 'Continue'}
                </button>
                <button type="button" onClick={() => addToast('Email sent successfully', 'success')}>
                    Test toast
                </button>
            </form>
        </AuthLayout>
    )
}