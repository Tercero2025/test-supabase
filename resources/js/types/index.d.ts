import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';
import { Page } from '@inertiajs/core';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
    subItems?: {
        title: string;
        href: string;
    }[];
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    is_superadmin: boolean;
    role?: {
        id: number;
        name: string;
    };
}


export interface InertiaPageProps {
    auth: {
        user: User;
    };
    [key: string]: unknown;
}

export type PageProps = InertiaPageProps;