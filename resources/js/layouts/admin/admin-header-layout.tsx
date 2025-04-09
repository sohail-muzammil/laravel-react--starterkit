import { AppContent } from '@/components/app-content';
import { AdminHeader } from '@/components/admin/admin-header';
import { AppShell } from '@/components/app-shell';
import { type BreadcrumbItem } from '@/types';
import type { PropsWithChildren } from 'react';

export default function AppHeaderLayout({ children, breadcrumbs }: PropsWithChildren<{ breadcrumbs?: BreadcrumbItem[] }>) {
    return (
        <AppShell>
            <AdminHeader breadcrumbs={breadcrumbs} />
            <AppContent>{children}</AppContent>
        </AppShell>
    );
}
