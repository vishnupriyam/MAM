#include <stdio.h>
#include <stdlib.h>
#include <malloc.h>

struct node {
	struct node *leftc;
	int info;
	struct node *rightc;
};

int height (struct node *root) 
{
    int hleftc,hrightc;
    
    if (root == NULL) {
             return 0;
    }
    hleftc = height(root->leftc);
    hrightc = height(root->rightc);
    if (hleftc > hrightc) {
              return hleftc + 1;
    } else {
              return hrightc + 1;
    }
}
    
    
    
    
    
    
    
    
    

struct node * insert_(struct node *root, int num)
{
	struct node *temp, *ptr, *par;
	ptr = root;
	par = NULL;
	while (ptr != NULL) {
		par = ptr;
		if (ptr->info == num) {
			printf("duplicate key\n");
			return root;
		}
		if (ptr->info < num) {
			ptr = ptr->rightc;
		} else if(ptr->info > num) {
			ptr = ptr->leftc;
		}
	}

	temp = (struct node *)malloc(sizeof(struct node));

    temp->info = num;
    temp->leftc = NULL;
    temp->rightc = NULL;

	if (par == NULL) {
		root = temp;
	} else {
		if(par->info < num) {
			par->rightc = temp;
		}

		if (par->info > num) {
			par->leftc = temp;
		}

	}

	return root;
}

int in_traverse(struct node *root)
{
	struct node *temp;

	temp = root;
	if (temp == NULL) {
		return 1;
	}

	in_traverse(temp->leftc);
	printf("root : %d", temp->info);
	in_traverse(temp->rightc);
	return 0;
}

int pre_traverse(struct node *root)
{
        struct node *temp;

        temp = root;
        if (temp == NULL) {
                return 1;
        }

        printf("root : %d   ", temp->info);
        if(root->leftc != NULL)
	    printf("left child : %d   ", temp->leftc->info);
	    if(root->rightc != NULL)
	    printf("right child : %d\n\n\n", temp->rightc->info);
	    pre_traverse(temp->leftc);
	    pre_traverse(temp->rightc);
        return 0;
}

int post_traverse(struct node *root)
{
        struct node *temp;

        temp = root;
        if (temp == NULL) {
                return 1;
        }

        post_traverse(temp->leftc);
        post_traverse(temp->rightc);
	    printf("%d\n", temp->info);
        return 0;
}

struct node *  find_min_key(struct node *root)
{
	struct node *temp;

	temp = root;

	if (temp != NULL) {
		while (temp->leftc != NULL) {
			temp = temp->leftc;
		}
	}
	return temp;
}

struct node *  find_max_key(struct node *root)
{
        struct node *temp;

        temp = root;

        if (temp != NULL) {
                while (temp->rightc != NULL) {
                        temp = temp->rightc;
                }
        }
        return temp;
}

int search_bst(struct node *root, int num)
{
	struct node *temp;

	temp = root;

	while (temp != NULL) {
		if (temp->info == num) {
			return 0;
		}
		if (temp->info < num) {
			temp = temp->rightc;
		} else if (temp->info > num) {
			temp = temp->leftc;
		}
	}
	return 1;
}

struct node * delete_ (struct node * root, int num)
{
    struct node *ptr, *par, *child, *succ, *par_of_succ;

    ptr = root;
    par = NULL;

    while (ptr != NULL) {
        if (num == ptr->info) {
            break;
        }
        par = ptr;
        if (num < ptr->info) {
            ptr = ptr->leftc;
        } else {
            ptr = ptr->rightc;
        }
    }

    if (ptr == NULL) {
        printf("no. not present");
        return root;
    }

    if (ptr->leftc != NULL && ptr->rightc != NULL) {
        par_of_succ = ptr;
        succ = ptr->rightc;
        while (succ->leftc != NULL) {
                par_of_succ = succ;
                succ = succ->leftc;
        }
        ptr->info = succ->info;
        ptr = succ;
        par = par_of_succ;
    }

    if (ptr->leftc != NULL) {
        child = ptr->leftc;
    } else {
        child = ptr->rightc;
    }

    if (par == NULL) {
        root = child;
    } else if (ptr == par->leftc) {
        par->leftc = child;
    } else {
        par->rightc = child;
    }

    free(ptr);
    return root;
}

int main()
{

	char choice[20];
	int num;
	struct node *root;
	struct node *temp;
	int a;
	int y;

	root = NULL;

	while (1) {
		scanf("%s", choice);
		if (strcmp("search_bst", choice) == 0) {
			scanf("%d", &num);
			a = search_bst(root, num);
			if (a == 0) {
				printf("found\n");
			} else {
				printf("not found\n");
			}
		}
		if (strcmp("exit", choice) == 0) {
			break;
		}
		if (strcmp("in_traverse", choice) == 0) {
                        a = in_traverse(root);
        }
		if (strcmp("pre_traverse", choice) == 0) {
                        a = pre_traverse(root);
        }
		if (strcmp("post_traverse", choice) == 0) {
                        a = post_traverse(root);
        }
		if (strcmp("insert", choice) == 0) {
                        scanf("%d", &num);
                        root = insert_(root, num);
        }
        if (strcmp("delete", choice) == 0) {
                        scanf("%d", &num);
                        root = delete_(root, num);
        }
		 if (strcmp("find_min_key", choice) == 0) {
                        temp = find_min_key(root);
			printf("%d", temp->info);
        }
		 if (strcmp("find_max_key", choice) == 0) {
                        temp = find_max_key(root);
			printf("%d", temp->info);
        }
	}

	return 0;
}



























