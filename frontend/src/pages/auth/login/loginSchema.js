import { z } from 'zod'

export const loginStep1Schema = z.object({
    identifier: z
        .string()
        .min(1, 'Email or username is required'),
})

export const loginStep2Schema = z.object({
    password: z
        .string()
        .min(1, 'Password is required'),
})