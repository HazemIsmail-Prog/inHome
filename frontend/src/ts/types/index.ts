// components
export type ButtonVariant = 'accent' | 'secondary' | 'danger' | 'warning' | 'info' | 'success'| 'link' | 'outline' | 'ghost' | 'text'

// models
export interface User {
    id: number
    name: TranslatableObject
    name_en: string
    name_ar: string
    email: string
    can: string[]
    is_active: boolean
    permissions: Permission[]
    roles: Role[]
}

export interface UserForm {
    id?: number | null
    name_en: string
    name_ar: string
    email: string
    password?: string
    is_active: boolean
    permissions: number[]
    roles: number[]
}

export type TranslatableObject = {
    ar: string
    en: string
} | undefined


export interface LoginForm {
    email: string
    password: string
}

export interface PermissionForm {
    id?: number | null
    name_en: string
    name_ar: string
}

export interface Permission {
    id: number
    name: TranslatableObject
    name_en: string
    name_ar: string
}

export interface RoleForm {
    id?: number | null
    name_en: string
    name_ar: string
    permissions: number[]
}

export interface Role {
    id: number
    name: TranslatableObject
    name_en: string
    name_ar: string
    permissions: Permission[]
}