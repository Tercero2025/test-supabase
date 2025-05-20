import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/react';
import { PlusIcon, PencilIcon, TrashIcon } from 'lucide-react';
import Swal from 'sweetalert2';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Clients',
        href: '/clients',
    },
];

interface Client {
    id: number;
    name: string;
    fullname: string;
    cuit: string;
    address?: string;
    city?: string;
    state?: string;
    country?: string;
}

export default function Clients({ clients }: { clients: Client[] }) {
    const handleDelete = (client: Client) => {
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete the client "${client.fullname}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                router.delete(route('clients.destroy', client.id), {
                    onSuccess: () => {
                        Swal.fire(
                            'Deleted!',
                            'The client has been deleted.',
                            'success'
                        )
                    },
                });
            }
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Clients" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-xl font-semibold">Clients</h1>
                    <Link href={route('clients.create')}>
                        <Button>
                            <PlusIcon className="mr-2 h-4 w-4" />
                            New Client
                        </Button>
                    </Link>
                </div>

                <div className="border-sidebar-border/70 dark:border-sidebar-border relative overflow-hidden rounded-xl border">
                    <div className="relative overflow-x-auto">
                        <Table>
                            <TableHeader>
                                <TableRow className="border-sidebar-border/70">
                                    <TableHead>Name</TableHead>
                                    <TableHead>Full Name</TableHead>
                                    <TableHead>CUIT</TableHead>
                                    <TableHead>City</TableHead>
                                    <TableHead className="w-[100px]">Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {clients.map((client) => (
                                    <TableRow key={client.id} className="border-sidebar-border/70">
                                        <TableCell className="font-medium">{client.name}</TableCell>
                                        <TableCell>{client.fullname}</TableCell>
                                        <TableCell>{client.cuit}</TableCell>
                                        <TableCell>{client.city}</TableCell>
                                        <TableCell>
                                            <div className="flex items-center gap-2">
                                                <Link href={route('clients.edit', client.id)}>
                                                    <Button variant="ghost" size="icon" className="h-8 w-8">
                                                        <PencilIcon className="h-4 w-4" />
                                                    </Button>
                                                </Link>
                                                <Button 
                                                    variant="ghost" 
                                                    size="icon" 
                                                    className="h-8 w-8"
                                                    onClick={() => handleDelete(client)}
                                                >
                                                    <TrashIcon className="h-4 w-4" />
                                                </Button>
                                            </div>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
