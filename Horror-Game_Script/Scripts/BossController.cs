using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.AI;
public class BossController : MonoBehaviour
{
    public GameObject player;
    private NavMeshAgent nav;
    private Animator anime;

    public int moveSpeed = 3;

    private bool canMove;
    // Start is called before the first frame update
    void Start()
    {
        nav = GetComponent<NavMeshAgent>();
        anime = GetComponent<Animator>();
        canMove = true;
        nav.speed = moveSpeed;
        anime.SetFloat("Dash", 10);
        anime.SetBool("Walk", true);
    }

    // Update is called once per frame
    void Update()
    {
        Move();
    }
    public void Move()
    {
        nav.destination = player.transform.position;
    }
    public void BossJumpOff()  //ジャンプアニメーション後の処理
    {
        anime.SetBool("Jump", false);
        nav.enabled = true;
    }
    public void AttackOff()
    {
        anime.SetBool("Walk", true);
        anime.SetBool("Attack1", true);
        anime.SetBool("Attack2", true);
        anime.SetBool("Attack3", true);
        anime.SetBool("Attack4", true);
    }
}
